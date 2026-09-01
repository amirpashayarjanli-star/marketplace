<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Exceptions\InsufficientWalletBalanceException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


/*
|--------------------------------------------------------------------------
| منطق مزایده (مناقصه)
|--------------------------------------------------------------------------
|
| کارمزد ثبت هر پیشنهاد = fee_percent درصد مبلغ همان پیشنهاد، از کیف‌پول
| کاربر کسر می‌شود. کاهش مبلغ پیشنهاد، تفاوت کارمزد را برمی‌گرداند.
| انصراف پیش از پایان مهلت، کل کارمزد را برمی‌گرداند. لغو مزایده توسط
| کارفرما/ادمین، کارمزد همه را برمی‌گرداند.
|
*/

class AuctionService
{

    public function __construct(
        protected SmsService $sms,
    ) {}


    // نقش‌های مجاز به ازای هر نوع کار در Auction::SCOPE_BIDDERS تعریف شده.


    /*
    |--------------------------------------------------------------------------
    | ثبت پیشنهاد
    |--------------------------------------------------------------------------
    */

    public function placeBid(Auction $auction, User $user, array $data): Bid
    {

        $this->assertCanBid($auction, $user);

        if ($auction->bids()->where('user_id', $user->id)->exists()) {
            throw ValidationException::withMessages([
                'amount' => 'شما قبلاً در این مزایده پیشنهاد داده‌اید. می‌توانید همان را ویرایش کنید.',
            ]);
        }

        $amount = (int) $data['amount'];

        $this->assertAmountSane($auction, $amount);

        $fee = $this->feeFor($auction, $amount);

        $bid = DB::transaction(function () use ($auction, $user, $data, $amount, $fee) {

            $bid = $auction->bids()->create([
                'user_id'       => $user->id,
                'amount'        => $amount,
                'delivery_days' => $data['delivery_days'] ?? null,
                'description'   => $data['description'] ?? null,
                'attachment'    => $data['attachment'] ?? null,
                'status'        => 'active',
            ]);

            if ($fee > 0) {
                $tx = Wallet::forUser($user)->debit(
                    $fee,
                    "کارمزد ثبت پیشنهاد در مزایده «{$auction->title}»",
                    $bid->id,
                );

                $bid->forceFill(['fee_transaction_id' => $tx->id])->save();
            }

            return $bid;
        });

        $auction->refresh()->extendIfSniped();

        return $bid;
    }


    /*
    |--------------------------------------------------------------------------
    | ویرایش پیشنهاد — فقط بهبود (کاهش مبلغ)
    |--------------------------------------------------------------------------
    */

    public function updateBid(Bid $bid, array $data): Bid
    {

        $auction = $bid->auction;

        if (! $auction->isOpen()) {
            throw ValidationException::withMessages([
                'amount' => 'مهلت این مزایده به پایان رسیده و ویرایش ممکن نیست.',
            ]);
        }

        if ($bid->status !== 'active') {
            throw ValidationException::withMessages([
                'amount' => 'این پیشنهاد دیگر فعال نیست.',
            ]);
        }

        $newAmount = (int) $data['amount'];

        if ($newAmount > $bid->amount) {
            throw ValidationException::withMessages([
                'amount' => 'مبلغ پیشنهاد فقط قابل کاهش است (بهبود پیشنهاد).',
            ]);
        }

        $this->assertAmountSane($auction, $newAmount);

        DB::transaction(function () use ($auction, $bid, $newAmount, $data) {

            $refund = $this->feeFor($auction, $bid->amount)
                - $this->feeFor($auction, $newAmount);

            if ($refund > 0) {
                Wallet::forUser($bid->user)->credit(
                    $refund,
                    "برگشت بخشی از کارمزد پس از کاهش پیشنهاد در مزایده «{$auction->title}»",
                );
            }

            $bid->update([
                'amount'        => $newAmount,
                'delivery_days' => $data['delivery_days'] ?? $bid->delivery_days,
                'description'   => $data['description'] ?? $bid->description,
            ]);
        });

        $auction->refresh()->extendIfSniped();

        return $bid->refresh();
    }


    /*
    |--------------------------------------------------------------------------
    | انصراف از پیشنهاد
    |--------------------------------------------------------------------------
    */

    public function withdrawBid(Bid $bid): void
    {

        $auction = $bid->auction;

        if (! $auction->isOpen()) {
            throw ValidationException::withMessages([
                'bid' => 'پس از پایان مهلت مزایده، انصراف ممکن نیست.',
            ]);
        }

        DB::transaction(function () use ($auction, $bid) {

            $this->refundFee($bid, "برگشت کارمزد پس از انصراف از مزایده «{$auction->title}»");

            // ردیف حذف می‌شود تا کاربر بتواند در صورت تمایل دوباره پیشنهاد بدهد.
            $bid->delete();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | اعلام برنده
    |--------------------------------------------------------------------------
    */

    public function award(Auction $auction, Bid $winner): void
    {

        if (! in_array($auction->status, ['active', 'closed'], true)) {
            throw ValidationException::withMessages([
                'auction' => 'این مزایده در وضعیتی نیست که بتوان برنده اعلام کرد.',
            ]);
        }

        if ($winner->auction_id !== $auction->id || $winner->status !== 'active') {
            throw ValidationException::withMessages([
                'auction' => 'پیشنهاد انتخاب‌شده معتبر نیست.',
            ]);
        }

        $losers = $auction->bids()
            ->where('status', 'active')
            ->where('id', '!=', $winner->id)
            ->get();

        DB::transaction(function () use ($auction, $winner, $losers) {

            $winner->update(['status' => 'won']);

            $auction->bids()
                ->where('status', 'active')
                ->where('id', '!=', $winner->id)
                ->update(['status' => 'lost']);

            $auction->update([
                'status'        => 'awarded',
                'winner_bid_id' => $winner->id,
                'ends_at'       => $auction->ends_at ?? Carbon::now(),
            ]);
        });

        $this->notify(
            $winner->user,
            "تبریک! پیشنهاد شما در مزایده «{$auction->title}» برنده شد. کارفرما با شما تماس می‌گیرد."
        );

        foreach ($losers as $loser) {
            $this->notify(
                $loser->user,
                "مزایده «{$auction->title}» به پیشنهاد دیگری واگذار شد. سپاس از مشارکت شما."
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | لغو مزایده
    |--------------------------------------------------------------------------
    */

    public function cancel(Auction $auction, ?string $reason = null): void
    {

        if (in_array($auction->status, ['awarded', 'cancelled'], true)) {
            throw ValidationException::withMessages([
                'auction' => 'این مزایده قابل لغو نیست.',
            ]);
        }

        $bids = $auction->bids()->where('status', 'active')->get();

        DB::transaction(function () use ($auction, $bids) {

            foreach ($bids as $bid) {
                $this->refundFee($bid, "برگشت کارمزد به‌دلیل لغو مزایده «{$auction->title}»");
                $bid->update(['status' => 'lost']);
            }

            $auction->update(['status' => 'cancelled']);
        });

        $tail = $reason ? " دلیل: {$reason}" : '';

        foreach ($bids as $bid) {
            $this->notify(
                $bid->user,
                "مزایده «{$auction->title}» لغو شد و کارمزد شما به کیف‌پول برگشت.".$tail
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | انتشار مزایده (خروج از پیش‌نویس/در انتظار تایید)
    |--------------------------------------------------------------------------
    |
    | زمان شروع را «الان» می‌گذارد و اگر پایان مهلت گذشته/خالی بود، یک
    | هفته از الان در نظر می‌گیرد. اطلاع‌رسانی پیامکی را دستور
    | زمان‌بندی‌شده‌ی auctions:notify انجام می‌دهد (notified_at هنوز null است).
    |
    */

    public function publish(Auction $auction, ?Carbon $endsAt = null): void
    {

        if (! $auction->readyToPublish()) {
            throw ValidationException::withMessages([
                'auction' => $auction->consultationFeeDue()
                    ? 'هزینه‌ی مشاوره هنوز پرداخت نشده است.'
                    : 'ابتدا باید مشاوره‌ی این مزایده ثبت شود.',
            ]);
        }

        $endsAt ??= ($auction->ends_at && $auction->ends_at->isFuture())
            ? $auction->ends_at
            : Carbon::now()->addDays(7);

        $auction->update([
            'status'      => 'active',
            'starts_at'   => $auction->starts_at ?? Carbon::now(),
            'ends_at'     => $endsAt,
            'notified_at' => null,
        ]);
    }




    /*
    |--------------------------------------------------------------------------
    | مشاوره‌ی پیش از انتشار
    |--------------------------------------------------------------------------
    */

    /**
     * کارفرما درخواست تماس می‌دهد — به مدیرها پیامک می‌رود.
     */
    public function requestCallback(Auction $auction): void
    {
        $auction->update(['callback_requested_at' => Carbon::now()]);

        $employerName = $auction->employer?->name ?? 'کارفرما';
        $mobile = $auction->employer?->user?->mobile ?? $auction->employer?->mobile ?? '—';

        foreach ((array) config('proauction.admin_mobiles', []) as $adminMobile) {
            $adminMobile = trim($adminMobile);
            if ($adminMobile !== '') {
                $this->sms->send(
                    $adminMobile,
                    "درخواست مشاوره‌ی پرو مزایده\n{$employerName} — {$mobile}\nمزایده: «{$auction->title}»"
                );
            }
        }
    }


    /**
     * کارفرما هزینه‌ی مشاوره را از کیف‌پول پرداخت می‌کند.
     */
    public function payConsultation(Auction $auction): void
    {
        if ($auction->consultationPaid()) {
            return;
        }

        $fee = (int) $auction->consultation_fee;

        if ($fee <= 0) {
            $auction->update(['consultation_paid_at' => Carbon::now()]);
            return;
        }

        $user = $auction->employer?->user;

        if (! $user) {
            throw ValidationException::withMessages([
                'auction' => 'کاربر کارفرما پیدا نشد.',
            ]);
        }

        DB::transaction(function () use ($auction, $user, $fee) {
            Wallet::forUser($user)->debit(
                $fee,
                "هزینه‌ی مشاوره‌ی پرو مزایده — «{$auction->title}»",
            );

            $auction->update(['consultation_paid_at' => Carbon::now()]);
        });
    }


    /**
     * مدیر پس از تماس، مشاوره را ثبت می‌کند. مزایده به «در انتظار تایید نهایی» می‌رود.
     */
    public function recordConsultation(Auction $auction, User $admin, ?string $note = null): void
    {
        $auction->update([
            'consulted_at'      => Carbon::now(),
            'consulted_by'      => $admin->id,
            'consultation_note' => $note,
            'status'            => 'pending_review',
        ]);

        $mobile = $auction->employer?->user?->mobile ?? $auction->employer?->mobile;

        if ($mobile) {
            $this->sms->send(
                $mobile,
                "مشاوره‌ی مزایده‌ی «{$auction->title}» انجام شد."
                .($auction->consultationFeeDue()
                    ? ' برای انتشار، هزینه‌ی مشاوره را از داشبورد پرداخت کنید.'
                    : ' به‌زودی منتشر می‌شود.')
            );
        }
    }




    /*
    |--------------------------------------------------------------------------
    | اطلاع‌رسانی پیامکی مزایده‌های تازه‌منتشرشده — از auctions:notify
    |--------------------------------------------------------------------------
    |
    | روی هاست اشتراکی صف نداریم، پس هر بار اجرا حداکثر چند مزایده را
    | پردازش می‌کند و پیامک را در دسته‌های کوچک می‌فرستد. پس از اتمام،
    | notified_at ست می‌شود تا دوباره ارسال نشود.
    |
    */

    public function sendNewAuctionNotifications(int $perRun = 3): int
    {

        $auctions = Auction::query()
            ->where('status', 'active')
            ->whereNull('notified_at')
            ->orderBy('id')
            ->limit($perRun)
            ->get();

        if ($auctions->isEmpty()) {
            return 0;
        }

        $recipients = User::query()
            ->where('type', 'company')
            ->where('status', 'approved')
            ->whereNotNull('mobile')
            ->pluck('mobile')
            ->unique()
            ->values();

        foreach ($auctions as $auction) {

            foreach ($recipients->chunk(100) as $chunk) {
                foreach ($chunk as $mobile) {
                    $this->sms->send(
                        $mobile,
                        "مناقصه‌ی جدید آسانسور در پرو مزایده: «{$auction->title}»"
                        .($auction->province ? " — {$auction->province}" : '')
                        ."\n".url("/auction/{$auction->slug}")
                    );
                }
            }

            $auction->update(['notified_at' => Carbon::now()]);
        }

        return $auctions->count();
    }




    /*
    |--------------------------------------------------------------------------
    | بستن مزایده‌های سررسیده — از دستور زمان‌بندی‌شده صدا زده می‌شود
    |--------------------------------------------------------------------------
    */

    public function closeEnded(): int
    {

        $due = Auction::query()
            ->where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<=', Carbon::now())
            ->with('employer.user')
            ->get();

        foreach ($due as $auction) {

            $auction->update(['status' => 'closed']);

            $mobile = $auction->employer?->user?->mobile ?? $auction->employer?->mobile;

            if ($mobile) {
                $this->sms->send(
                    $mobile,
                    "مهلت مزایده «{$auction->title}» به پایان رسید. برای انتخاب برنده به داشبورد سر بزنید."
                );
            }
        }

        return $due->count();
    }


    /*
    |--------------------------------------------------------------------------
    | کمکی‌ها
    |--------------------------------------------------------------------------
    */

    public function feeFor(Auction $auction, int $amount): int
    {
        $percent = (float) ($auction->fee_percent ?? config('proauction.fee_percent', 5));

        return (int) round($amount * $percent / 100);
    }


    private function assertCanBid(Auction $auction, User $user): void
    {

        if (! $auction->isOpen()) {
            throw ValidationException::withMessages([
                'amount' => 'این مزایده باز نیست.',
            ]);
        }

        if (! $auction->bids_enabled) {
            throw ValidationException::withMessages([
                'amount' => 'برای این مزایده ثبت پیشنهاد روی سایت فعال نیست.',
            ]);
        }

        if ($user->status !== 'approved') {
            throw ValidationException::withMessages([
                'amount' => 'تا تایید نشدن حسابتان نمی‌توانید پیشنهاد بدهید.',
            ]);
        }

        if (! in_array($user->type, $auction->allowedBidderTypes(), true)) {
            throw ValidationException::withMessages([
                'amount' => 'برای این نوع کار فقط '.$auction->allowedBiddersLabel().' می‌توانند پیشنهاد بدهند.',
            ]);
        }

        if ($auction->employer && $auction->employer->user_id === $user->id) {
            throw ValidationException::withMessages([
                'amount' => 'روی مزایده‌ی خودتان نمی‌توانید پیشنهاد بدهید.',
            ]);
        }
    }


    private function assertAmountSane(Auction $auction, int $amount): void
    {

        if ($amount < 1) {
            throw ValidationException::withMessages([
                'amount' => 'مبلغ پیشنهاد نامعتبر است.',
            ]);
        }

        if ($auction->budget_max && $amount > $auction->budget_max) {
            throw ValidationException::withMessages([
                'amount' => 'مبلغ پیشنهاد از سقف بودجه‌ی کارفرما بیشتر است.',
            ]);
        }
    }


    private function refundFee(Bid $bid, string $reason): void
    {

        // کارمزدی پرداخت نشده بود.
        if (! $bid->fee_transaction_id) {
            return;
        }

        // جلوگیری از برگشت دوباره‌ی کل کارمزد یک پیشنهاد.
        $alreadyRefunded = WalletTransaction::query()
            ->where('bid_id', $bid->id)
            ->where('type', 'credit')
            ->exists();

        if ($alreadyRefunded) {
            return;
        }

        // کارمزد همیشه برابر ۵٪ مبلغ فعلی است (کاهش‌های قبلی تفاوتش را
        // پس داده‌اند)، پس همین مقدار باید برگردد.
        $fee = $this->feeFor($bid->auction, $bid->amount);

        if ($fee > 0) {
            Wallet::forUser($bid->user)->credit($fee, $reason, null, $bid->id);
        }
    }


    private function notify(User $user, string $text): void
    {
        if ($user->mobile) {
            $this->sms->send($user->mobile, $text);
        }
    }
}

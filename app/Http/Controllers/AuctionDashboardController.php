<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Project;
use App\Services\AuctionService;
use App\Exceptions\InsufficientWalletBalanceException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| پرو مزایده — سمت کارفرما
|--------------------------------------------------------------------------
*/

class AuctionDashboardController extends Controller
{

    public function __construct(
        protected AuctionService $auctions,
    ) {}




    public function index()
    {

        $employerId = $this->employerId();

        $auctions = Auction::query()
            ->where('employer_id', $employerId)
            ->withCount(['bids' => fn ($q) => $q->where('status', 'active')])
            ->latest()
            ->get();

        return view('dashboard.auctions.index', compact('auctions'));
    }




    public function create()
    {

        $employerId = $this->employerId();

        $projects = Project::where('employer_id', $employerId)
            ->whereDoesntHave('auction')
            ->latest()
            ->get(['id', 'title']);

        return view('dashboard.auctions.create', [
            'projects'  => $projects,
            'scopes'    => Auction::SCOPES,
            'minDate'   => Carbon::now()->addHours(config('proauction.min_duration_hours', 24))->format('Y-m-d'),
            'maxDate'   => Carbon::now()->addDays(config('proauction.max_duration_days', 30))->format('Y-m-d'),
        ]);
    }




    public function store(Request $request)
    {

        $employerId = $this->employerId();

        $data = $request->validate([
            'title'        => 'required|string|max:150',
            'scope'        => 'required|in:'.implode(',', array_keys(Auction::SCOPES)),
            'description'  => 'required|string|max:5000',
            'province'     => 'nullable|string|max:60',
            'city'         => 'nullable|string|max:60',
            'budget_max'   => 'nullable|integer|min:0',
            'ends_on'      => 'required|date|after:today',
            'project_id'   => 'nullable|integer',
            'specs'        => 'nullable|string|max:2000',
        ]);

        $minEnd = Carbon::now()->addHours(config('proauction.min_duration_hours', 24));
        $maxEnd = Carbon::now()->addDays(config('proauction.max_duration_days', 30));
        $endsAt = Carbon::parse($data['ends_on'])->endOfDay();

        if ($endsAt->lessThan($minEnd) || $endsAt->greaterThan($maxEnd)) {
            return back()
                ->withInput()
                ->withErrors(['ends_on' => 'مدت مزایده باید بین '
                    .config('proauction.min_duration_hours', 24).' ساعت و '
                    .config('proauction.max_duration_days', 30).' روز باشد.']);
        }

        // پروژه‌ی انتخابی باید مال همین کارفرما و بدون مزایده باشد.
        $projectId = null;
        if (! empty($data['project_id'])) {
            $projectId = Project::where('id', $data['project_id'])
                ->where('employer_id', $employerId)
                ->whereDoesntHave('auction')
                ->value('id');
        }

        $auction = Auction::create([
            'slug'               => str()->slug($data['title']).'-'.time(),
            'source'             => 'onsite',
            'project_id'         => $projectId,
            'employer_id'        => $employerId,
            'title'              => $data['title'],
            'description'        => $data['description'],
            'scope'              => $data['scope'],
            'province'           => $data['province'] ?? null,
            'city'               => $data['city'] ?? null,
            'budget_max'         => $data['budget_max'] ?? null,
            'specs'              => ! empty($data['specs']) ? ['note' => $data['specs']] : null,
            'ends_at'            => $endsAt,
            'anti_snipe_minutes' => config('proauction.anti_snipe_minutes', 10),
            'fee_percent'        => config('proauction.fee_percent', 5),
            'consultation_fee'   => config('proauction.consultation_fee', 0),
            'status'             => 'awaiting_consultation',
        ]);

        return redirect()
            ->route('dashboard.auctions.show', $auction)
            ->with('success', 'مزایده ثبت شد. برای انتشار، مرحله‌ی مشاوره را کامل کنید.');
    }




    public function show(Auction $auction)
    {

        $this->authorizeOwner($auction);

        $auction->load([
            'bids' => fn ($q) => $q->orderBy('amount')->orderBy('created_at'),
            'bids.user.company',
            'bids.user.manufacturer',
            'bids.user.technician',
            'winnerBid.user',
            'project',
        ]);

        return view('dashboard.auctions.show', [
            'auction'           => $auction,
            'consultationPhone' => config('proauction.consultation_phone'),
        ]);
    }




    /*
    |--------------------------------------------------------------------------
    | مشاوره‌ی پیش از انتشار
    |--------------------------------------------------------------------------
    */

    public function requestCallback(Auction $auction)
    {
        $this->authorizeOwner($auction);

        abort_unless($auction->needsConsultation(), 403, 'این مزایده به مشاوره نیاز ندارد.');

        $this->auctions->requestCallback($auction);

        return back()->with('success', 'درخواست تماس ثبت شد. کارشناسان ما با شما تماس می‌گیرند.');
    }




    public function payConsultation(Auction $auction)
    {
        $this->authorizeOwner($auction);

        if ($auction->consultationPaid()) {
            return back()->with('success', 'هزینه‌ی مشاوره قبلاً پرداخت شده است.');
        }

        try {
            $this->auctions->payConsultation($auction);
        } catch (InsufficientWalletBalanceException $e) {
            return redirect()
                ->route('wallet')
                ->with('error', 'موجودی کیف‌پول برای پرداخت هزینه‌ی مشاوره کافی نیست. ابتدا شارژ کنید.');
        }

        return back()->with('success', 'هزینه‌ی مشاوره پرداخت شد.');
    }




    public function award(Request $request, Auction $auction)
    {

        $this->authorizeOwner($auction);

        $data = $request->validate([
            'bid_id' => 'required|integer',
        ]);

        $bid = $auction->bids()->findOrFail($data['bid_id']);

        $this->auctions->award($auction, $bid);

        return back()->with('success', 'برنده‌ی مزایده اعلام شد.');
    }




    public function cancel(Request $request, Auction $auction)
    {

        $this->authorizeOwner($auction);

        $data = $request->validate([
            'reason' => 'nullable|string|max:300',
        ]);

        $this->auctions->cancel($auction, $data['reason'] ?? null);

        return back()->with('success', 'مزایده لغو شد و کارمزد پیشنهادها برگشت داده شد.');
    }




    /*
    |--------------------------------------------------------------------------
    | کمکی‌ها
    |--------------------------------------------------------------------------
    */

    private function employerId(): int
    {
        $id = Auth::user()->employer?->id;

        abort_if($id === null, 403, 'فقط کارفرماها می‌توانند مزایده بسازند.');

        return $id;
    }


    private function authorizeOwner(Auction $auction): void
    {
        abort_unless(
            $auction->employer_id === Auth::user()->employer?->id,
            403,
            'دسترسی رد شد.'
        );
    }
}

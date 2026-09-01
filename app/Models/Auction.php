<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class Auction extends Model
{

    protected static function booted(): void
    {
        static::creating(function (Auction $auction) {
            if (empty($auction->slug)) {
                $auction->slug = Str::slug($auction->title) ?: 'auction';
                $auction->slug .= '-'.mb_substr((string) time(), -6);
            }
        });
    }


    protected $fillable = [

        'slug',
        'source',
        'project_id',
        'employer_id',
        'title',
        'description',
        'scope',
        'province',
        'city',
        'tender_no',
        'organization',
        'category',
        'source_url',
        'published_at',
        'budget_max',
        'specs',
        'starts_at',
        'ends_at',
        'anti_snipe_minutes',
        'status',
        'winner_bid_id',
        'fee_percent',
        'bids_enabled',
        'notified_at',
        'consulted_at',
        'consultation_note',
        'consulted_by',
        'callback_requested_at',
        'consultation_fee',
        'consultation_paid_at',

    ];


    protected $casts = [

        'specs'                 => 'array',
        'published_at'          => 'datetime',
        'starts_at'             => 'datetime',
        'ends_at'               => 'datetime',
        'notified_at'           => 'datetime',
        'consulted_at'          => 'datetime',
        'callback_requested_at' => 'datetime',
        'consultation_paid_at'  => 'datetime',
        'budget_max'            => 'integer',
        'consultation_fee'      => 'integer',
        'fee_percent'           => 'decimal:2',
        'bids_enabled'          => 'boolean',

    ];


    public const SCOPES = [
        'install'       => 'نصب آسانسور',
        'modernization' => 'مدرن‌سازی',
        'service'       => 'سرویس و نگهداری',
        'parts'         => 'تامین تجهیزات',
    ];


    public const STATUSES = [
        'draft'                 => 'پیش‌نویس',
        'awaiting_consultation' => 'در انتظار مشاوره',
        'pending_review'        => 'در انتظار تایید نهایی',
        'active'                => 'در حال برگزاری',
        'closed'                => 'پایان مهلت',
        'awarded'               => 'واگذار شده',
        'cancelled'             => 'لغو شده',
    ];


    public const SOURCES = [
        'onsite'   => 'ثبت‌شده در سایت',
        'external' => 'سامانه ستاد',
    ];


    /*
    | چه نقش‌هایی مجازند در هر نوع کار پیشنهاد بدهند.
    | نصب و مدرن‌سازی کار شرکت است؛ تامین تجهیزات کار تولیدکننده و
    | فروشگاه؛ سرویس و نگهداری را شرکت و تکنسین هر دو می‌گیرند.
    */
    public const SCOPE_BIDDERS = [
        'install'       => ['company'],
        'modernization' => ['company'],
        'service'       => ['company', 'technician'],
        'parts'         => ['manufacturer', 'store'],
    ];


    public const TYPE_LABELS = [
        'company'      => 'شرکت آسانسوری',
        'manufacturer' => 'تولیدکننده',
        'technician'   => 'تکنسین',
        'store'        => 'فروشگاه',
    ];


    /**
     * نقش‌هایی که می‌توانند روی این مزایده پیشنهاد بدهند.
     */
    public function allowedBidderTypes(): array
    {
        return self::SCOPE_BIDDERS[$this->scope] ?? ['company'];
    }


    public function allowedBiddersLabel(): string
    {
        return collect($this->allowedBidderTypes())
            ->map(fn ($type) => self::TYPE_LABELS[$type] ?? $type)
            ->join('، ', ' و ');
    }


    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }


    public function sourceLabel(): string
    {
        return self::SOURCES[$this->source] ?? $this->source;
    }


    public function isExternal(): bool
    {
        return $this->source === 'external';
    }


    /*
    |--------------------------------------------------------------------------
    | مشاوره‌ی پیش از انتشار
    |--------------------------------------------------------------------------
    */

    public function needsConsultation(): bool
    {
        return $this->source === 'onsite' && $this->consulted_at === null;
    }


    public function consultationPaid(): bool
    {
        return $this->consultation_paid_at !== null;
    }


    public function consultationFeeDue(): bool
    {
        return (int) $this->consultation_fee > 0 && ! $this->consultationPaid();
    }


    /**
     * آیا مزایده آماده‌ی «تایید و انتشار» توسط مدیر است؟
     */
    public function readyToPublish(): bool
    {
        if ($this->isExternal()) {
            return true;
        }

        return $this->consulted_at !== null && ! $this->consultationFeeDue();
    }


    /*
    |--------------------------------------------------------------------------
    | روابط
    |--------------------------------------------------------------------------
    */

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }


    public function winnerBid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, 'winner_bid_id');
    }


    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consulted_by');
    }


    /*
    |--------------------------------------------------------------------------
    | اسکوپ‌ها
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }


    public function scopePublic($query)
    {
        return $query->whereIn('status', ['active', 'closed', 'awarded']);
    }


    /*
    |--------------------------------------------------------------------------
    | کمک‌متدها
    |--------------------------------------------------------------------------
    */

    public function isOpen(): bool
    {
        return $this->status === 'active'
            && $this->ends_at !== null
            && $this->ends_at->isFuture();
    }


    public function scopeLabel(): string
    {
        return self::SCOPES[$this->scope] ?? $this->scope;
    }


    /**
     * کمترین پیشنهاد فعال — «پیشنهاد پیشرو» در مناقصه.
     */
    public function leadingBid(): ?Bid
    {
        return $this->bids()
            ->where('status', 'active')
            ->orderBy('amount')
            ->orderBy('created_at')
            ->first();
    }


    /**
     * اگر مهلت در بازه‌ی ضد اسنایپ است، آن را از «الان» تمدید می‌کند.
     * برمی‌گرداند که تمدید انجام شد یا نه.
     */
    public function extendIfSniped(): bool
    {
        if (! $this->isOpen() || ! $this->anti_snipe_minutes) {
            return false;
        }

        $threshold = Carbon::now()->addMinutes($this->anti_snipe_minutes);

        if ($this->ends_at->greaterThan($threshold)) {
            return false;
        }

        $this->forceFill([
            'ends_at' => Carbon::now()->addMinutes($this->anti_snipe_minutes),
        ])->save();

        return true;
    }
}

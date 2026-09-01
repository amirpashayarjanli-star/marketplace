@extends('dashboard.layouts.dashboard')


@section('content')


<div class="mb-6">
    <a href="{{ route('dashboard.auctions') }}" class="text-blue-600">← مزایده‌های من</a>
</div>


@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
        <ul class="list-inside list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- مرحله‌ی مشاوره — تا کامل نشود، مزایده منتشر نمی‌شود --}}

@if($auction->source === 'onsite' && ! in_array($auction->status, ['cancelled', 'awarded']) && ! $auction->readyToPublish())

    <div class="mb-6 rounded-2xl border-2 border-amber-300 bg-gradient-to-l from-amber-50 to-white p-7 shadow">

        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-500 text-2xl">☎️</span>
            <div>
                <h2 class="text-xl font-extrabold text-amber-900">مرحله‌ی مشاوره‌ی تخصصی</h2>
                <p class="text-sm text-amber-700">پیش از انتشار مزایده، کارشناسان ما پروژه‌ی شما را بررسی می‌کنند.</p>
            </div>
        </div>

        <ul class="mb-5 space-y-1.5 text-sm text-slate-700">
            <li>✅ بررسی مشخصات فنی و برآورد واقعی هزینه</li>
            <li>✅ تنظیم درست شرح پروژه تا شرکت‌های معتبر پیشنهاد بدهند</li>
            <li>✅ راهنمایی برای انتخاب بهترین پیشنهاد از میان رقبا</li>
        </ul>

        {{-- گام ۱: تماس --}}
        <div class="mb-4 rounded-xl bg-white p-5 ring-1 ring-amber-200">
            <div class="mb-2 flex items-center gap-2">
                <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">گام ۱</span>
                <span class="font-bold text-slate-800">تماس با کارشناس</span>
                @if($auction->consulted_at)
                    <span class="mr-auto rounded bg-green-100 px-2 py-0.5 text-xs font-bold text-green-700">انجام شد</span>
                @endif
            </div>

            @unless($auction->consulted_at)
                <p class="mb-3 text-sm text-slate-600">با شماره‌ی زیر تماس بگیرید یا درخواست تماس ثبت کنید تا ما تماس بگیریم.</p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="tel:{{ $consultationPhone }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-6 py-3 text-lg font-black text-white shadow hover:bg-amber-600">
                        📞 {{ $consultationPhone }}
                    </a>

                    @if($auction->callback_requested_at)
                        <span class="text-sm text-slate-500">
                            درخواست تماس ثبت شد ({{ jdatetime($auction->callback_requested_at) }})
                        </span>
                    @else
                        <form method="POST" action="{{ route('dashboard.auctions.callback', $auction) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-xl border border-amber-300 px-5 py-3 text-sm font-bold text-amber-800 hover:bg-amber-50">
                                ما با من تماس بگیرید
                            </button>
                        </form>
                    @endif
                </div>
            @endunless
        </div>

        {{-- گام ۲: پرداخت هزینه‌ی مشاوره --}}
        @if((int) $auction->consultation_fee > 0)
            <div class="rounded-xl bg-white p-5 ring-1 ring-amber-200">
                <div class="mb-2 flex items-center gap-2">
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">گام ۲</span>
                    <span class="font-bold text-slate-800">پرداخت هزینه‌ی مشاوره</span>
                    @if($auction->consultationPaid())
                        <span class="mr-auto rounded bg-green-100 px-2 py-0.5 text-xs font-bold text-green-700">پرداخت شد</span>
                    @endif
                </div>

                @unless($auction->consultationPaid())
                    <p class="mb-3 text-sm text-slate-600">
                        مبلغ <strong class="text-slate-900">{{ number_format($auction->consultation_fee) }} تومان</strong>
                        از کیف‌پول شما کسر می‌شود. پس از پرداخت، مزایده منتشر می‌شود.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <form method="POST" action="{{ route('dashboard.auctions.pay-consultation', $auction) }}"
                              onsubmit="return confirm('مبلغ {{ number_format($auction->consultation_fee) }} تومان از کیف‌پول کسر شود؟')">
                            @csrf
                            <button type="submit"
                                    class="rounded-xl bg-green-600 px-6 py-3 font-bold text-white hover:bg-green-700">
                                پرداخت از کیف‌پول
                            </button>
                        </form>

                        <a href="{{ route('wallet') }}"
                           class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">
                            شارژ کیف‌پول
                        </a>
                    </div>
                @endunless
            </div>
        @endif

    </div>

@elseif($auction->source === 'onsite' && $auction->consulted_at && $auction->status === 'pending_review')

    <div class="mb-6 rounded-2xl border border-green-300 bg-green-50 p-5">
        <p class="font-bold text-green-800">✅ مشاوره کامل شد — مزایده در انتظار تایید نهایی مدیر است.</p>
        <p class="mt-1 text-sm text-green-700">به‌محض تایید، به فهرست عمومی مزایده‌ها می‌رود و به شرکت‌ها پیامک اطلاع‌رسانی می‌شود.</p>
    </div>

@endif


<div class="bg-white rounded-2xl shadow p-6 mb-6">

    <div class="flex items-center justify-between mb-3">
        <h1 class="text-2xl font-bold">{{ $auction->title }}</h1>
        <span class="text-sm font-bold px-3 py-1 rounded bg-slate-100 text-slate-700">
            {{ $auction->statusLabel() }}
        </span>
    </div>

    <div class="space-y-1 text-gray-600 text-sm">
        <p>{{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}</p>
        <p>📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}</p>
        @if($auction->ends_at)
            <p>پایان مهلت: {{ jdatetime($auction->ends_at) }} ({{ jdiff($auction->ends_at) }})</p>
        @endif
        <p>کارمزد هر پیشنهاد: {{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪</p>
    </div>

    <p class="mt-4 whitespace-pre-line text-gray-700">{{ $auction->description }}</p>

    @if(!in_array($auction->status, ['awarded', 'cancelled']))
        <form method="POST" action="{{ route('dashboard.auctions.cancel', $auction) }}" class="mt-5"
              onsubmit="return confirm('مزایده لغو شود؟ کارمزد همه‌ی پیشنهادها برگشت داده می‌شود.')">
            @csrf
            <input type="text" name="reason" placeholder="دلیل لغو (اختیاری)"
                   class="rounded-xl border border-gray-300 px-3 py-2 text-sm">
            <button type="submit" class="mr-2 rounded-xl border border-red-200 px-4 py-2 text-sm font-bold text-red-600">
                لغو مزایده
            </button>
        </form>
    @endif

</div>


<h2 class="text-xl font-bold mb-3">پیشنهادها ({{ $auction->bids->whereIn('status', ['active','won','lost'])->count() }})</h2>

<div class="bg-white rounded-2xl shadow overflow-x-auto">
    <table class="w-full text-right text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr>
                <th class="p-3 font-semibold">پیشنهاددهنده</th>
                <th class="p-3 font-semibold">مبلغ (تومان)</th>
                <th class="p-3 font-semibold">زمان تحویل</th>
                <th class="p-3 font-semibold">توضیح</th>
                <th class="p-3 font-semibold">اقدام</th>
            </tr>
        </thead>
        <tbody>
            @php $leadingId = optional($auction->bids->where('status','active')->sortBy('amount')->first())->id; @endphp
            @forelse($auction->bids->whereIn('status', ['active','won','lost'])->sortBy('amount') as $bid)
                <tr class="border-t border-slate-100 @if($bid->id === $leadingId) bg-green-50 @endif">
                    <td class="p-3 font-semibold text-slate-700">
                        {{ $bid->user->company->name
                            ?? $bid->user->manufacturer->name
                            ?? $bid->user->technician->name
                            ?? $bid->user->name }}
                        @if($bid->id === $leadingId)
                            <span class="mr-1 rounded bg-green-600 px-1.5 py-0.5 text-[10px] text-white">پیشرو</span>
                        @endif
                        @if($bid->status === 'won')
                            <span class="mr-1 rounded bg-blue-600 px-1.5 py-0.5 text-[10px] text-white">برنده</span>
                        @endif
                    </td>
                    <td class="p-3 font-bold text-slate-800">{{ number_format($bid->amount) }}</td>
                    <td class="p-3 text-slate-500">{{ $bid->delivery_days ? $bid->delivery_days.' روز' : '—' }}</td>
                    <td class="p-3 text-slate-500">{{ $bid->description ?: '—' }}</td>
                    <td class="p-3">
                        @if($bid->status === 'active' && in_array($auction->status, ['active','closed']))
                            <form method="POST" action="{{ route('dashboard.auctions.award', $auction) }}"
                                  onsubmit="return confirm('این پیشنهاد به‌عنوان برنده انتخاب شود؟')">
                                @csrf
                                <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-bold text-white">
                                    اعلام برنده
                                </button>
                            </form>
                        @else
                            —
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-slate-400">هنوز پیشنهادی ثبت نشده است.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection

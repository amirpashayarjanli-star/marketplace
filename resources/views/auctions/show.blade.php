@extends('layouts.app')


@section('title', $auction->title . ' — پرو مزایده')


@section('content')


@include('sections.header-inner')



<main class="directory-page">

    <div class="container-app">


        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-100 p-4 text-green-700">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl bg-red-100 p-4 text-red-700">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl bg-red-100 p-4 text-red-700">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">


            {{-- ستون اصلی --}}

            <div class="lg:col-span-2">

                <div class="mb-2 flex items-center gap-2">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                        {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
                    </span>
                    <span class="text-xs font-bold
                        @class([
                            'text-green-600' => $auction->status === 'active',
                            'text-amber-600' => $auction->status === 'closed',
                            'text-blue-600'  => $auction->status === 'awarded',
                            'text-red-600'   => $auction->status === 'cancelled',
                        ])">
                        {{ $auction->statusLabel() }}
                    </span>
                </div>

                <h1 class="mb-3 text-2xl font-extrabold text-slate-800">{{ $auction->title }}</h1>

                <p class="mb-4 text-sm text-slate-500">
                    📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                    @if($auction->employer)
                        &nbsp;·&nbsp; کارفرما: {{ $auction->employer->name }}
                    @endif
                </p>

                @if($auction->isExternal())
                    <div class="mb-6 rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">
                        <div class="mb-2 flex items-center gap-2 font-bold">
                            <span class="rounded bg-sky-600 px-2 py-0.5 text-[11px] text-white">سامانه ستاد</span>
                            این مناقصه از سامانه‌ی تدارکات الکترونیکی دولت بازنشر شده است.
                        </div>
                        <dl class="grid grid-cols-1 gap-1 sm:grid-cols-2">
                            @if($auction->organization)
                                <div><dt class="inline text-sky-700">دستگاه مناقصه‌گزار:</dt> <dd class="inline font-semibold">{{ $auction->organization }}</dd></div>
                            @endif
                            @if($auction->tender_no)
                                <div><dt class="inline text-sky-700">شماره فراخوان:</dt> <dd class="inline font-semibold">{{ $auction->tender_no }}</dd></div>
                            @endif
                            @if($auction->category)
                                <div><dt class="inline text-sky-700">طبقه‌بندی:</dt> <dd class="inline font-semibold">{{ $auction->category }}</dd></div>
                            @endif
                            @if($auction->published_at)
                                <div><dt class="inline text-sky-700">تاریخ انتشار:</dt> <dd class="inline font-semibold">{{ jdate($auction->published_at) }}</dd></div>
                            @endif
                        </dl>
                        @if($auction->source_url)
                            <a href="{{ $auction->source_url }}" target="_blank" rel="noopener"
                               class="mt-3 inline-block rounded-lg bg-sky-600 px-4 py-2 text-xs font-bold text-white">
                                مشاهده و شرکت در سامانه ستاد ↗
                            </a>
                        @endif
                    </div>
                @endif

                <div class="prose prose-slate mb-6 max-w-none whitespace-pre-line text-slate-700">{{ $auction->description }}</div>

                @if($auction->specs && !empty($auction->specs['note']))
                    <div class="mb-6 rounded-xl bg-slate-50 p-4 text-sm text-slate-600 whitespace-pre-line">
                        <strong class="mb-1 block">مشخصات فنی:</strong>
                        {{ $auction->specs['note'] }}
                    </div>
                @endif



                {{-- جدول پیشنهادها --}}

                <h2 class="mb-3 mt-8 text-xl font-bold text-slate-800">
                    پیشنهادها ({{ $auction->bids->where('status', '!=', 'withdrawn')->count() }})
                </h2>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="w-full text-right text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="p-3 font-semibold">پیشنهاددهنده</th>
                                <th class="p-3 font-semibold">مبلغ (تومان)</th>
                                <th class="p-3 font-semibold">زمان تحویل</th>
                                <th class="p-3 font-semibold">ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $leadingId = optional($auction->bids->where('status','active')->sortBy('amount')->first())->id; @endphp
                            @forelse($auction->bids->whereIn('status', ['active','won','lost']) as $bid)
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
                                        @auth
                                            @if($bid->user_id === auth()->id())
                                                <span class="mr-1 text-[10px] text-slate-400">(شما)</span>
                                            @endif
                                        @endauth
                                    </td>
                                    <td class="p-3 font-bold text-slate-800">{{ number_format($bid->amount) }}</td>
                                    <td class="p-3 text-slate-500">{{ $bid->delivery_days ? $bid->delivery_days.' روز' : '—' }}</td>
                                    <td class="p-3 text-slate-400">{{ jdate($bid->created_at) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-6 text-center text-slate-400">هنوز پیشنهادی ثبت نشده است.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>



            {{-- ستون کناری — پنل اقدام --}}

            <div>

                <div class="sticky top-28 rounded-2xl border border-slate-200 bg-white p-6">

                    <div class="mb-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">وضعیت</span>
                            <span class="font-bold text-slate-700">{{ $auction->statusLabel() }}</span>
                        </div>
                        @if($auction->ends_at)
                            <div class="flex justify-between">
                                <span class="text-slate-500">پایان مهلت</span>
                                <span class="font-bold text-slate-700">{{ jdatetime($auction->ends_at) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-500">مجاز به پیشنهاد</span>
                            <span class="font-bold text-slate-700">{{ $auction->allowedBiddersLabel() }}</span>
                        </div>
                        @if($auction->budget_max)
                            <div class="flex justify-between">
                                <span class="text-slate-500">سقف بودجه</span>
                                <span class="font-bold text-slate-700">{{ number_format($auction->budget_max) }} ت</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-500">کارمزد هر پیشنهاد</span>
                            <span class="font-bold text-slate-700">{{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪</span>
                        </div>
                    </div>


                    @guest

                        <a href="{{ route('login') }}"
                           class="block rounded-xl bg-blue-600 py-3 text-center font-bold text-white">
                            برای ثبت پیشنهاد وارد شوید
                        </a>

                    @else

                        @if($myBid)

                            <div class="mb-4 rounded-xl bg-slate-50 p-4 text-sm">
                                <p class="mb-1 text-slate-500">پیشنهاد فعلی شما</p>
                                <p class="text-lg font-extrabold text-slate-800">{{ number_format($myBid->amount) }} تومان</p>
                                @if($myBid->delivery_days)
                                    <p class="text-slate-500">تحویل: {{ $myBid->delivery_days }} روز</p>
                                @endif
                            </div>

                            @if($auction->isOpen() && $myBid->status === 'active')

                                <form method="POST" action="{{ route('dashboard.bids.update', $myBid) }}" class="space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="mb-1 block text-sm font-semibold text-slate-600">مبلغ جدید (فقط کاهش)</label>
                                        <input type="number" name="amount" required max="{{ $myBid->amount }}"
                                               value="{{ old('amount', $myBid->amount) }}"
                                               class="w-full rounded-xl border border-slate-300 px-3 py-2">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm font-semibold text-slate-600">زمان تحویل (روز)</label>
                                        <input type="number" name="delivery_days" value="{{ old('delivery_days', $myBid->delivery_days) }}"
                                               class="w-full rounded-xl border border-slate-300 px-3 py-2">
                                    </div>

                                    <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 font-bold text-white">
                                        به‌روزرسانی پیشنهاد
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('dashboard.bids.withdraw', $myBid) }}" class="mt-2"
                                      onsubmit="return confirm('از پیشنهاد انصراف می‌دهید؟ کارمزد به کیف‌پول برمی‌گردد.')">
                                    @csrf
                                    <button type="submit" class="w-full rounded-xl border border-red-200 py-2.5 text-sm font-bold text-red-600">
                                        انصراف از پیشنهاد
                                    </button>
                                </form>

                            @endif

                        @elseif($canBid)

                            <form method="POST" action="{{ route('auction.bids.store', $auction) }}" class="space-y-3">
                                @csrf

                                <div>
                                    <label class="mb-1 block text-sm font-semibold text-slate-600">مبلغ پیشنهادی (تومان)</label>
                                    <input type="number" name="amount" required min="1" value="{{ old('amount') }}"
                                           class="w-full rounded-xl border border-slate-300 px-3 py-2"
                                           @if($auction->budget_max) max="{{ $auction->budget_max }}" @endif>
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-semibold text-slate-600">زمان تحویل (روز)</label>
                                    <input type="number" name="delivery_days" value="{{ old('delivery_days') }}"
                                           class="w-full rounded-xl border border-slate-300 px-3 py-2">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-semibold text-slate-600">توضیح (اختیاری)</label>
                                    <textarea name="description" rows="3"
                                              class="w-full rounded-xl border border-slate-300 px-3 py-2">{{ old('description') }}</textarea>
                                </div>

                                <p class="rounded-lg bg-amber-50 p-3 text-xs text-amber-700">
                                    هنگام ثبت، کارمزد
                                    {{ rtrim(rtrim(number_format($auction->fee_percent, 2), '0'), '.') }}٪
                                    مبلغ پیشنهاد از کیف‌پول شما کسر می‌شود. با انصراف یا لغو مزایده، برمی‌گردد.
                                </p>

                                <button type="submit" class="w-full rounded-xl bg-green-600 py-3 font-bold text-white">
                                    ثبت پیشنهاد
                                </button>
                            </form>

                        @else

                            <p class="rounded-xl bg-slate-50 p-4 text-center text-sm text-slate-500">
                                @if(!$auction->bids_enabled)
                                    ثبت پیشنهاد روی سایت برای این مناقصه فعال نیست.
                                    @if($auction->source_url) از طریق دکمه‌ی سامانه ستاد اقدام کنید. @endif
                                @elseif(!$auction->isOpen())
                                    مهلت این مزایده به پایان رسیده است.
                                @else
                                    برای این نوع کار فقط {{ $auction->allowedBiddersLabel() }}
                                    (تاییدشده) می‌توانند پیشنهاد بدهند.
                                @endif
                            </p>

                        @endif

                    @endguest

                </div>

            </div>


        </div>


    </div>

</main>



@include('sections.footer')


@endsection

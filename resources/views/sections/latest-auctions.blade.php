@if($latestAuctions->isNotEmpty())

<section class="home-section">

    <div class="container-app">

        <x-section-title
            title="پرو مزایده"
            description="مناقصه‌های باز پروژه‌های آسانسوری — پیشنهاد بدهید یا پروژه‌تان را به مزایده بگذارید"
            :url="route('auctions.index')"
        />


        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            @foreach($latestAuctions as $auction)

                <a href="{{ route('auction.show', $auction->slug) }}"
                   class="block rounded-2xl border border-slate-200 bg-white p-6 transition hover:border-blue-400 hover:shadow-lg">

                    <div class="mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
                            </span>
                            @if($auction->isExternal())
                                <span class="rounded-full bg-sky-100 px-2 py-1 text-[11px] font-bold text-sky-700">ستاد</span>
                            @endif
                        </div>
                        <span class="text-xs font-bold text-green-600">در حال برگزاری</span>
                    </div>

                    <h3 class="mb-2 text-lg font-extrabold text-slate-800">{{ $auction->title }}</h3>

                    @if($auction->organization)
                        <p class="mb-1 text-sm text-slate-500">🏛️ {{ $auction->organization }}</p>
                    @endif

                    <p class="mb-4 text-sm text-slate-500">
                        📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - '.$auction->city : '' }}
                    </p>

                    <div class="flex items-center justify-between border-t border-slate-100 pt-3 text-sm">
                        <span class="text-slate-500">{{ $auction->bids_count }} پیشنهاد</span>
                        <span class="font-bold text-slate-700">
                            @if($auction->leading_amount)
                                پیشرو: {{ number_format($auction->leading_amount) }} ت
                            @else
                                بدون پیشنهاد
                            @endif
                        </span>
                    </div>

                    @if($auction->ends_at)
                        <p class="mt-3 text-xs text-slate-400">
                            پایان مهلت: {{ jdatetime($auction->ends_at) }} ({{ jdiff($auction->ends_at) }})
                        </p>
                    @endif

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif

<section class="latest-auctions">

    <div class="container-app">

        <x-section-title
            title="پرو مزایده"
            description="مناقصه‌های باز پروژه‌های آسانسوری — پیشنهاد بدهید یا پروژه‌تان را به مزایده بگذارید"
            :url="route('auctions.index')"
        />


        <div class="latest-auctions-grid">

            @forelse($latestAuctions ?? [] as $auction)

                <a href="{{ route('auction.show', $auction->slug) }}" class="auction-home-card">

                    <div class="auction-home-card-top">

                        <span class="auction-home-scope">
                            {{ \App\Models\Auction::SCOPES[$auction->scope] ?? $auction->scope }}
                        </span>

                        @if($auction->isExternal())
                            <span class="auction-home-badge">ستاد</span>
                        @endif

                    </div>


                    <h3 class="auction-home-title">{{ $auction->title }}</h3>


                    @if($auction->organization)
                        <p class="auction-home-meta">🏛️ {{ $auction->organization }}</p>
                    @endif

                    <p class="auction-home-meta">
                        📍 {{ $auction->province ?: '—' }}{{ $auction->city ? ' - ' . $auction->city : '' }}
                    </p>


                    <div class="auction-home-foot">

                        <span>{{ $auction->bids_count }} پیشنهاد</span>

                        <span>
                            @if($auction->leading_amount)
                                پیشرو: {{ number_format($auction->leading_amount) }} تومان
                            @else
                                بدون پیشنهاد
                            @endif
                        </span>

                    </div>


                    @if($auction->ends_at)
                        <p class="auction-home-meta auction-home-deadline">
                            پایان مهلت: {{ jdatetime($auction->ends_at) }} ({{ jdiff($auction->ends_at) }})
                        </p>
                    @endif

                </a>

            @empty

                {{--
                | عمداً کل بخش را پنهان نمی‌کنیم: پرو مزایده یکی از دو محصول
                | اصلی سایت است و نبودنش از صفحه‌ی اصلی یعنی کاربر تازه اصلاً
                | نمی‌فهمد چنین چیزی هست.
                --}}
                <div class="slider-empty">

                    <x-ui.icon name="certificate" />

                    <h3>
                        الان مزایده‌ی بازی نیست.
                    </h3>

                    <p>
                        مناقصه‌های تازه به‌محض تایید همین‌جا نمایش داده می‌شوند.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</section>

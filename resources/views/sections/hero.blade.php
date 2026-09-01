{{--
    هیروی صفحه‌ی اصلی — سه ستون
    ------------------------------------------------------------------
    راست : متن معرفی و دکمه‌ها
    وسط  : نرخ لحظه‌ای دلار / طلا / سکه
    چپ   : اسلایدر تصویری که از پنل مدیریت تنظیم میشه
--}}

<section class="hero">

    <div class="hero-aura hero-aura-a" aria-hidden="true"></div>
    <div class="hero-aura hero-aura-b" aria-hidden="true"></div>

    <div class="container-app">

        <div class="hero-grid">


            {{-- ستون ۱ — متن --}}

            <div class="hero-intro">

                <span class="hero-eyebrow">
                    <x-ui.icon name="bolt" :size="15" />
                    مرجع صنعت آسانسور ایران
                </span>

                <h1 class="hero-title">
                    شروع هر پروژه از
                    <br>
                    <span class="brand-blue">آسانسور</span><span class="brand-yellow">پرو</span>
                </h1>

                <p class="hero-lead">
                    شرکت‌های آسانسوری، تولیدکنندگان، فروشگاه‌ها، تکنسین‌ها
                    و پروژه‌های ساختمانی را در یک‌جا پیدا کنید.
                </p>

                <div class="hero-actions">

                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        شروع کنید
                        <x-ui.icon name="arrow-left" :size="18" />
                    </a>

                    <a href="{{ route('service.index') }}" class="btn btn-lg pro-service-btn pro-service-btn-lg">
                        <span class="pro-service-pro">پرو</span><span class="pro-service-service">سرویس</span>
                    </a>

                    <a href="{{ route('auctions.index') }}" class="btn btn-lg pro-service-btn pro-auction-btn pro-service-btn-lg">
                        <span class="pro-service-pro">پرو</span><span class="pro-auction-word">مزایده</span>
                    </a>

                </div>

                <ul class="hero-trust">
                    <li><x-ui.icon name="shield" :size="16" /> شرکت‌های تاییدشده</li>
                    <li><x-ui.icon name="bolt" :size="16" /> پاسخ سریع</li>
                    <li><x-ui.icon name="star" :size="16" /> امتیاز واقعی کاربران</li>
                </ul>

            </div>


            {{-- ستون ۲ — نرخ بازار --}}

            <div class="hero-rates" role="region" aria-label="نرخ لحظه‌ای بازار">

                @foreach($marketRates as $key => $rate)

                    @php
                        $tone = match($key){
                            'usd'  => 'mint',
                            'gold' => 'lemon',
                            default => 'sky',
                        };
                        $icon = match($key){
                            'usd'  => 'bolt',
                            'gold' => 'star',
                            default => 'certificate',
                        };
                        $toman = \App\Services\MarketRatesService::toToman($rate['value']);
                        $up = ($rate['change'] ?? 0) > 0;
                    @endphp

                    <article class="rate-card">

                        <span class="rate-icon tint-{{ $tone }}">
                            <x-ui.icon :name="$icon" :size="18" />
                        </span>

                        <div class="rate-body">

                            <span class="rate-label">{{ $rate['label'] }}</span>

                            @if($rate['available'])

                                <strong class="rate-value">
                                    {{ number_format($toman) }}
                                    <small>{{ $rate['unit'] }}</small>
                                </strong>

                                @if(!empty($rate['change']))
                                    <span class="rate-change {{ $up ? 'is-up' : 'is-down' }}">
                                        {{ $up ? '▲' : '▼' }}
                                        {{ number_format(abs(\App\Services\MarketRatesService::toToman($rate['change']))) }}
                                    </span>
                                @endif

                            @else

                                {{-- منبع این نرخ هنوز وصل نشده؛ عدد جعلی نمایش نمی‌دهیم --}}
                                <span class="rate-pending">به‌زودی</span>

                            @endif

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- ستون ۳ — اسلایدر --}}

            <div class="hero-slider"
                 x-data="heroSlider({{ $heroSlides->count() }})"
                 x-init="start()"
                 @mouseenter="stop()"
                 @mouseleave="start()">

                @forelse($heroSlides as $i => $slide)

                    <figure class="hero-slide"
                            x-show="current === {{ $i }}"
                            x-transition.opacity.duration.600ms
                            @if($i > 0) style="display:none" @endif>

                        <img src="{{ asset('storage/' . $slide->image) }}"
                             alt="{{ $slide->title ?? 'اسلاید' }}"
                             loading="{{ $i === 0 ? 'eager' : 'lazy' }}">

                        @if($slide->title || $slide->hasButton())
                            <figcaption class="hero-slide-caption">

                                @if($slide->title)
                                    <strong>{{ $slide->title }}</strong>
                                @endif

                                @if($slide->subtitle)
                                    <span>{{ $slide->subtitle }}</span>
                                @endif

                                @if($slide->hasButton())
                                    <a href="{{ $slide->button_url }}" class="btn btn-primary btn-sm">
                                        {{ $slide->button_label }}
                                    </a>
                                @endif

                            </figcaption>
                        @endif

                    </figure>

                @empty

                    {{-- هنوز اسلایدی ثبت نشده --}}
                    <div class="hero-slide hero-slide-empty">
                        <x-ui.icon name="building" :size="34" />
                        <strong>اسلایدی ثبت نشده</strong>
                        <span>از پنل مدیریت › اسلایدر صفحه اصلی اضافه کنید.</span>
                    </div>

                @endforelse


                @if($heroSlides->count() > 1)
                    <div class="hero-slider-dots">
                        @foreach($heroSlides as $i => $slide)
                            <button type="button"
                                    @click="go({{ $i }})"
                                    :class="{ 'is-active': current === {{ $i }} }"
                                    aria-label="اسلاید {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                @endif

            </div>


        </div>

    </div>

</section>

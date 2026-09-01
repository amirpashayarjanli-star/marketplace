{{--
    بخش عضویت
    ------------------------------------------------------------------
    مهم‌ترین نقطه‌ی جذب کاربر در صفحه‌ی اصلی. قبلاً همه‌ی لینک‌هاش
    مرده بودن و آیکون‌هاش PNGهای قدیمی با کارت‌های خالی بزرگ.
--}}

@php
    $types = [
        ['icon' => 'building', 'label' => 'شرکت آسانسوری', 'desc' => 'نصب و نگهداری', 'tone' => 'sky',   'route' => 'companies.index'],
        ['icon' => 'industry', 'label' => 'تولیدکننده',    'desc' => 'قطعات و کابین', 'tone' => 'lilac', 'route' => 'manufacturers.index'],
        ['icon' => 'shop',     'label' => 'فروشگاه',       'desc' => 'خرید تجهیزات',  'tone' => 'peach', 'route' => 'stores.index'],
        ['icon' => 'wrench',   'label' => 'تکنسین',        'desc' => 'تعمیر و سرویس', 'tone' => 'mint',  'route' => 'technicians.index'],
    ];

    $benefits = ['ثبت‌نام رایگان', 'پروفایل اختصاصی', 'فرصت‌های همکاری'];
@endphp

<section class="collaboration-section">

    <div class="container-app">

        <div class="collaboration-box glass">

            <div class="collaboration-content">

                <span class="collaboration-badge">
                    <x-ui.icon name="star" :size="14" />
                    عضویت در آسانسور پرو
                </span>

                <h2 class="collaboration-title">
                    به خانواده
                    <span class="brand-name"><span class="brand-blue">آسانسور</span><span class="brand-yellow">پرو</span></span>
                    بپیوندید.
                </h2>

                <p class="collaboration-description">
                    اگر تولیدکننده، فروشگاه، شرکت آسانسوری یا تکنسین هستید،
                    همین امروز عضو شوید و کسب‌وکار خود را در بزرگ‌ترین جامعه
                    تخصصی صنعت آسانسور معرفی کنید.
                </p>

                <div class="collaboration-actions">

                    <a href="{{ route('register') }}" class="btn btn-primary">
                        ثبت‌نام رایگان
                    </a>

                    <a href="{{ route('login') }}" class="btn btn-outline">
                        ورود اعضا
                    </a>

                </div>

                <ul class="collaboration-features">
                    @foreach($benefits as $benefit)
                        <li class="feature-item">
                            <x-ui.icon name="circle-check" :size="17" />
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>

            </div>


            <div class="collaboration-icons">

                @foreach($types as $type)

                    <a href="{{ route($type['route']) }}" class="collaboration-card">

                        <span class="icon-box tint-{{ $type['tone'] }}">
                            <x-ui.icon :name="$type['icon']" :size="28" />
                        </span>

                        <strong>{{ $type['label'] }}</strong>
                        <small>{{ $type['desc'] }}</small>

                    </a>

                @endforeach

            </div>


        </div>

    </div>

</section>

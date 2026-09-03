@php
    $links = [
        ['image' => 'companies.jpg', 'label' => 'شرکت‌ها',      'desc' => 'نصب و نگهداری', 'tone' => 'sky',   'route' => 'companies.index'],
        ['image' => 'manufacturers.jpg', 'label' => 'تولیدکنندگان', 'desc' => 'قطعات و کابین', 'tone' => 'lilac', 'route' => 'manufacturers.index'],
        ['image' => 'stores.jpg',     'label' => 'فروشگاه‌ها',   'desc' => 'خرید تجهیزات',  'tone' => 'peach', 'route' => 'stores.index'],
        ['image' => 'technicians.jpg',   'label' => 'تکنسین‌ها',    'desc' => 'تعمیر و سرویس', 'tone' => 'mint',  'route' => 'technicians.index'],
        ['image' => 'projects.jpg',   'label' => 'پروژه‌ها',     'desc' => 'فرصت همکاری',   'tone' => 'lemon', 'route' => 'projects.index'],
    ];
@endphp

<section class="quick-access-section">

    <div class="container-app">

        <div class="section-header">
            <div class="section-header-right">
                <span class="section-subtitle">دسترسی سریع</span>
                <h2>دنبال چه چیزی هستید؟</h2>
            </div>
        </div>

        <div class="quick-access-grid">

            @foreach($links as $link)

                <a href="{{ route($link['route']) }}" class="quick-card">

                    <span class="quick-icon tint-{{ $link['tone'] }}">
                        <img src="{{ asset('images/trust-bar/' . $link['image']) }}" alt="{{ $link['label'] }}" class="quick-image" />
                    </span>

                    <h3>{{ $link['label'] }}</h3>

                    <p>{{ $link['desc'] }}</p>

                </a>

            @endforeach

        </div>

    </div>

</section>

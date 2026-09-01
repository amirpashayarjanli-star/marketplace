@php
    $links = [
        ['icon' => 'building', 'label' => 'شرکت‌ها',      'desc' => 'نصب و نگهداری', 'tone' => 'sky',   'route' => 'companies.index'],
        ['icon' => 'industry', 'label' => 'تولیدکنندگان', 'desc' => 'قطعات و کابین', 'tone' => 'lilac', 'route' => 'manufacturers.index'],
        ['icon' => 'shop',     'label' => 'فروشگاه‌ها',   'desc' => 'خرید تجهیزات',  'tone' => 'peach', 'route' => 'stores.index'],
        ['icon' => 'wrench',   'label' => 'تکنسین‌ها',    'desc' => 'تعمیر و سرویس', 'tone' => 'mint',  'route' => 'technicians.index'],
        ['icon' => 'clipboard',   'label' => 'پروژه‌ها',     'desc' => 'فرصت همکاری',   'tone' => 'lemon', 'route' => 'projects.index'],
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
                        <x-ui.icon :name="$link['icon']" :size="26" />
                    </span>

                    <h3>{{ $link['label'] }}</h3>

                    <p>{{ $link['desc'] }}</p>

                </a>

            @endforeach

        </div>

    </div>

</section>

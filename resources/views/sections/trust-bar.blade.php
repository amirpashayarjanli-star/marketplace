{{--
    نوار اعتماد
    ------------------------------------------------------------------
    اعداد از دیتابیس میان، نه دستی. فقط موارد تاییدشده شمرده میشن —
    یعنی دقیقاً همون تعدادی که کاربر بعد از کلیک در فهرست می‌بینه.
    (قبلاً این اعداد ثابت و ساختگی بودن.)
--}}

@php
    $items = [
        ['key' => 'companies',     'icon' => 'building', 'label' => 'شرکت آسانسوری', 'tone' => 'sky',   'route' => 'companies.index'],
        ['key' => 'manufacturers', 'icon' => 'industry', 'label' => 'تولیدکننده',    'tone' => 'lilac', 'route' => 'manufacturers.index'],
        ['key' => 'stores',        'icon' => 'shop',     'label' => 'فروشگاه',       'tone' => 'peach', 'route' => 'stores.index'],
        ['key' => 'technicians',   'icon' => 'wrench',   'label' => 'تکنسین',        'tone' => 'mint',  'route' => 'technicians.index'],
        ['key' => 'projects',      'icon' => 'clipboard',   'label' => 'پروژه',         'tone' => 'lemon', 'route' => 'projects.index'],
    ];
@endphp

<section class="trust-bar">

    <div class="container-app">

        <div class="trust-wrapper glass">

            @foreach($items as $item)

                <a href="{{ route($item['route']) }}" class="trust-item">

                    <span class="trust-icon tint-{{ $item['tone'] }}">
                        <x-ui.icon :name="$item['icon']" :size="24" />
                    </span>

                    <strong class="trust-value">
                        {{ number_format($stats[$item['key']] ?? 0) }}
                    </strong>

                    <span class="trust-label">{{ $item['label'] }}</span>

                </a>

            @endforeach

        </div>

    </div>

</section>

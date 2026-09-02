@props([
    'name',
    'size' => 20,
    'stroke' => 1.75,
])

{{--
    ست آیکون اختصاصی آسانسور پرو
    ------------------------------------------------------------------
    همه روی شبکه‌ی ۲۴×۲۴، خطی، سر و گوشه‌های گرد — هماهنگ با تم
    «روشن و زنده». عمداً SVG درون‌خطی‌ان نه فونت آیکون، چون:
      ۱) وابستگی خارجی (که اصلاً لود نمیشد) حذف میشه
      ۲) رنگ رو از currentColor می‌گیرن، پس با تم شب خودکار جور میشن
      ۳) در ایران به CDN خارجی وابسته نیستیم

    استفاده:  <x-ui.icon name="phone" />
              <x-ui.icon name="star" :size="16" />
--}}

@php
    // نام‌های هم‌معنا به یک آیکون می‌رسن تا کاربردهای قدیمی هم کار کنه
    $aliases = [
        'search'            => 'magnifying-glass',
        'store'             => 'shop',
        'zap'               => 'bolt',
        'lightning'         => 'bolt',
        'mobile-screen'     => 'mobile',
        'check-circle'      => 'circle-check',
        'calendar-days'     => 'calendar',
        'message'           => 'comments',
        'building-circle-check' => 'building-check',
        'project'           => 'clipboard',
        'projects'          => 'clipboard',
    ];

    $key = $aliases[$name] ?? $name;

    $paths = match ($key) {

        // ---- ناوبری ----
        'arrow-left'   => '<path d="M19 12H5M5 12l6-6M5 12l6 6"/>',
        'arrow-right'  => '<path d="M5 12h14M19 12l-6-6M19 12l-6 6"/>',
        'chevron-left' => '<path d="M15 6l-6 6 6 6"/>',
        'chevron-right'=> '<path d="M9 6l6 6-6 6"/>',
        'chevron-down' => '<path d="M6 9l6 6 6-6"/>',
        'bars'         => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close'        => '<path d="M6 6l12 12M18 6L6 18"/>',

        // ---- موجودیت‌های سایت ----
        'building'     => '<path d="M4 21h16"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16"/><path d="M10 7h.01M14 7h.01M10 11h.01M14 11h.01M10 15h.01M14 15h.01"/>',
        'building-check' => '<path d="M4 21h10"/><path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v6"/><path d="M10 7h.01M14 7h.01M10 11h.01"/><path d="M15 18l2 2 4-4"/>',
        'industry'     => '<path d="M3 21h18"/><path d="M3 21V10l6 4V10l6 4V7a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v14"/><path d="M18 11h.01M18 15h.01"/>',
        'shop'         => '<path d="M3 9.5 4.6 5a2 2 0 0 1 1.9-1.3h11a2 2 0 0 1 1.9 1.3L21 9.5"/><path d="M3 9.5h18v1.8a2.7 2.7 0 0 1-5.4 0 2.7 2.7 0 0 1-5.4 0 2.7 2.7 0 0 1-5.4 0Z"/><path d="M5 14v6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-6"/>',
        'screwdriver-wrench' => '<path d="M14.5 5.5a3.5 3.5 0 0 0 4.6 4.6l-7.7 7.7a2.3 2.3 0 0 1-3.2-3.2Z"/><path d="M6 6l2.5 2.5"/><path d="M4.5 9.5 3 8V4h4l1.5 1.5"/>',
        'wrench'       => '<path d="M17.5 4.5a4.7 4.7 0 0 0-6.1 5.9L4.8 17a2 2 0 0 0 2.8 2.8l6.6-6.6a4.7 4.7 0 0 0 5.9-6.1l-3 3-2.4-.4-.4-2.4Z"/>',
        'users'        => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20a6 6 0 0 1 12 0"/><path d="M16 5.2a3.2 3.2 0 0 1 0 5.6"/><path d="M18 20a5.6 5.6 0 0 0-2.5-4.6"/>',
        'clipboard'    => '<rect x="6" y="4.5" width="12" height="17" rx="2.2"/><path d="M9.2 4.5a1.4 1.4 0 0 1 1.4-1.4h2.8a1.4 1.4 0 0 1 1.4 1.4v1.2H9.2Z"/><path d="M9.5 11h5M9.5 14.5h5M9.5 18h3"/>',
        'folder-open'  => '<path d="M3 8a2 2 0 0 1 2-2h3.6a2 2 0 0 1 1.5.7l1 1.3H17a2 2 0 0 1 2 2"/><path d="m3 8 1.8 10.4A2 2 0 0 0 6.8 20h10.4a2 2 0 0 0 2-1.6L21 11H6.6a2 2 0 0 0-2 1.6L3 20"/>',
        'newspaper'    => '<path d="M4 5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2Z"/><path d="M17 8h2a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2"/><path d="M7 8h7M7 12h7M7 16h4"/>',
        'layer-group'  => '<path d="m12 3 8.5 4.2a.5.5 0 0 1 0 .9L12 12.3 3.5 8.1a.5.5 0 0 1 0-.9Z"/><path d="m4 12 8 4 8-4"/><path d="m4 16.5 8 4 8-4"/>',
        'cubes'        => '<path d="m12 2.5 4.5 2.3v4.7L12 11.8 7.5 9.5V4.8Z"/><path d="m5.5 12.5 4.5 2.3v4.7L5.5 21.8 1 19.5v-4.7Z" transform="translate(1 -1)"/><path d="m18 12.5 4.5 2.3v4.7L18 21.8l-4.5-2.3v-4.7Z" transform="translate(-1 -1)"/>',
        'boxes-stacked'=> '<path d="M8 3h8v5H8Z"/><path d="M3.5 11h8v5h-8Z"/><path d="M12.5 11h8v5h-8Z"/><path d="M8 19h8v2H8Z"/>',
        'tags'         => '<path d="M3.5 11.7V5a1.5 1.5 0 0 1 1.5-1.5h6.7a2 2 0 0 1 1.4.6l7 7a2 2 0 0 1 0 2.8l-5.4 5.4a2 2 0 0 1-2.8 0l-7-7a2 2 0 0 1-.6-1.4Z"/><circle cx="8" cy="8" r="1.4"/>',

        // ---- ارتباط ----
        'phone'        => '<path d="M6.2 3.5h3l1.5 4-2 1.4a12 12 0 0 0 5.4 5.4l1.4-2 4 1.5v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4.2 5.7a2 2 0 0 1 2-2.2Z"/>',
        'mobile'       => '<rect x="7" y="2.5" width="10" height="19" rx="2.4"/><path d="M11 18.5h2"/>',
        'comments'     => '<path d="M20 12.5a7 7 0 0 1-9.6 6.5L5 20.5l1.6-4.7A7 7 0 1 1 20 12.5Z"/><path d="M9 11h6M9 14h4"/>',
        'paper-plane'  => '<path d="M21 3 10.5 13.5"/><path d="M21 3l-6.8 18-3.7-7.5L3 9.8Z"/>',
        'globe'        => '<circle cx="12" cy="12" r="9"/><path d="M3.5 9.5h17M3.5 14.5h17"/><path d="M12 3a15 15 0 0 1 0 18a15 15 0 0 1 0-18Z"/>',
        'location-dot' => '<path d="M12 21.5s7-6.1 7-11a7 7 0 1 0-14 0c0 4.9 7 11 7 11Z"/><circle cx="12" cy="10.5" r="2.6"/>',
        'magnifying-glass' => '<circle cx="10.5" cy="10.5" r="6.5"/><path d="m21 21-5.8-5.8"/>',
        'calendar'     => '<rect x="3.5" y="5" width="17" height="16" rx="2.4"/><path d="M3.5 10h17"/><path d="M8 3v4M16 3v4"/>',

        // ---- وضعیت ----
        'check'        => '<path d="m5 13 4.5 4.5L19 7"/>',
        'circle-check' => '<circle cx="12" cy="12" r="9"/><path d="m8 12.3 2.7 2.7L16 9.7"/>',
        'circle-exclamation' => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5"/><path d="M12 16.3h.01"/>',
        'star'         => '<path d="m12 3.5 2.7 5.6 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9Z"/>',
        'shield'       => '<path d="M12 21.5s7.5-3.4 7.5-9.3V6.1L12 3.2 4.5 6.1v6.1c0 5.9 7.5 9.3 7.5 9.3Z"/><path d="m9 12 2.2 2.2L15.5 10"/>',
        'certificate'  => '<circle cx="12" cy="9.5" r="5.5"/><path d="m8.5 14.5-1 6 4.5-2.4 4.5 2.4-1-6"/>',
        'bolt'         => '<path d="M13.5 2.5 5 13.2h5.6l-.6 8.3L19 10.8h-5.6Z"/>',
        'trash'        => '<path d="M4.5 7h15"/><path d="M9.5 7V5.2a1.2 1.2 0 0 1 1.2-1.2h2.6a1.2 1.2 0 0 1 1.2 1.2V7"/><path d="M6.5 7.5 7.4 19a2 2 0 0 0 2 1.9h5.2a2 2 0 0 0 2-1.9L17.5 7.5"/><path d="M10.5 11v6M13.5 11v6"/>',

        /*
        | ---- نرخ بازار ----
        | این سه فقط روی کارت‌های نرخ هیرو استفاده میشن و هرکدوم باید
        | از یک نگاه شناخته بشن، چون برچسبشون ریزه.
        */

        // دسته اسکناس — دو برگ پشت هم و علامت دلار روی برگ رو
        'banknotes'    => '<rect x="2.5" y="7.5" width="15" height="9.5" rx="1.8"/><path d="M6.5 20.5h11.4a3.6 3.6 0 0 0 3.6-3.6V10"/><circle cx="10" cy="12.2" r="2.1"/><path d="M10 9.6v5.2"/>',

        /*
        | شمش طلا — ذوزنقه‌ی پلکانی.
        | نسخه‌ی اولش سرِ باریک و گرد داشت که شبیه دسته می‌شد و کل آیکون
        | وزنه خونده می‌شد؛ پهن‌کردن پله‌ی بالا مشکل رو حل کرد.
        */
        'gold-bar'     => '<path d="M6.4 11.4h11.2l1.5 6.2H4.9Z"/><path d="M7.4 7.4h9.2l.9 4"/>',

        // سکه — دایره با لبه‌ی داخلی
        'coin'         => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="5.4"/><path d="M12 9.6v4.8"/>',

        // ---- امنیت ----
        'lock'         => '<rect x="4.5" y="10" width="15" height="11" rx="2.4"/><path d="M8 10V7.2a4 4 0 0 1 8 0V10"/><path d="M12 14.5v2.5"/>',
        'lock-open'    => '<rect x="4.5" y="10" width="15" height="11" rx="2.4"/><path d="M8 10V7.2a4 4 0 0 1 7.6-1.7"/><path d="M12 14.5v2.5"/>',
        'eye'          => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3.2"/>',
        'eye-slash'    => '<path d="M4 4l16 16"/><path d="M9.5 9.7A3.2 3.2 0 0 0 14.3 14"/><path d="M6.6 6.8C4.2 8.4 2.5 12 2.5 12S6 18.5 12 18.5c1.7 0 3.2-.5 4.5-1.2"/><path d="M19.2 15.3c1.4-1.5 2.3-3.3 2.3-3.3S18 5.5 12 5.5c-.8 0-1.5.1-2.2.3"/>',

        default        => '<circle cx="12" cy="12" r="9"/>',
    };
@endphp

<svg {{ $attributes->merge(['class' => 'ap-icon']) }}
     width="{{ $size }}"
     height="{{ $size }}"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="{{ $stroke }}"
     stroke-linecap="round"
     stroke-linejoin="round"
     aria-hidden="true"
     focusable="false">{!! $paths !!}</svg>

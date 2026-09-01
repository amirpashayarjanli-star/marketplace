@php
    $user = auth()->user();

    $roleLabels = [
        'company'      => 'شرکت آسانسوری',
        'employer'     => 'کارفرما',
        'technician'   => 'تکنسین',
        'manufacturer' => 'تولیدکننده',
        'store'        => 'فروشگاه',
        'customer'     => 'مشتری',
    ];
@endphp


<header class="dashboard-header">


    {{-- دکمه‌ی منو — فقط موبایل --}}
    <button type="button"
            class="dashboard-nav-toggle"
            x-on:click="nav = ! nav"
            aria-label="منوی داشبورد">
        <span></span>
        <span></span>
        <span></span>
    </button>


    <div class="dashboard-header-greeting">

        <h3>سلام، {{ $user->name ?: 'کاربر' }} 👋</h3>

        <p>به داشبورد آسانسور پرو خوش آمدید</p>

    </div>


    <div class="dashboard-header-actions">

        <span class="badge">{{ $roleLabels[$user->type] ?? $user->type }}</span>

        <x-header.theme-toggle />

    </div>


</header>

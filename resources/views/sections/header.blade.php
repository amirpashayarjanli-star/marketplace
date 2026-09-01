<header class="fixed inset-x-0 top-0 z-50 pt-5">

    <div class="container-app">

        <div class="glass-premium radius-xl flex h-20 items-center justify-between gap-3 px-6">

            {{-- Logo --}}
            <x-header.logo />


            {{-- Desktop Navigation --}}
            <div class="hidden min-w-0 lg:block">
                <x-header.navigation />
            </div>


            {{-- Mobile Menu --}}
            <x-header.mobile-menu />


            {{-- Right --}}
            <div class="header-actions flex shrink-0 items-center gap-3">

                <x-header.search />


                <x-header.theme-toggle />


                @auth
                    <a href="{{ auth()->user()->type === 'customer' ? route('service.index') : route('dashboard') }}"
                       class="header-account-btn"
                       title="داشبورد"
                       aria-label="داشبورد">
                        <x-header.account-icon />
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="header-account-btn"
                       title="ورود | ثبت‌نام"
                       aria-label="ورود | ثبت‌نام">
                        <x-header.account-icon />
                    </a>
                @endauth

            </div>


        </div>

    </div>

</header>
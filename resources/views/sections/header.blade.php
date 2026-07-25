<header class="fixed inset-x-0 top-0 z-50 pt-5">

    <div class="container-app">

        <div class="glass-premium radius-xl flex h-20 items-center justify-between px-6">

            {{-- Logo --}}
            <x-header.logo />


            {{-- Desktop Navigation --}}
            <div class="hidden lg:block">
                <x-header.navigation />
            </div>


            {{-- Mobile Menu --}}
            <x-header.mobile-menu />


            {{-- Right --}}
            <div class="header-actions flex items-center gap-4">

                <x-header.search />


                <a href="#"
                   class="btn btn-primary">
                    ورود | ثبت‌نام
                </a>

            </div>


        </div>

    </div>

</header>
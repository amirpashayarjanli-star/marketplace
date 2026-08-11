<aside class="w-72 bg-white shadow-lg min-h-screen p-5">

    <h2 class="text-2xl font-bold mb-8">
        <span class="text-blue-600">
            آسانسور
        </span>
        <span class="text-yellow-500">
            پرو
        </span>
    </h2>

    <nav class="space-y-2">

        <a href="{{ route('dashboard') }}"
           class="block p-3 rounded-xl hover:bg-gray-100 transition">
            🏠 داشبورد
        </a>

        <a href="{{ route('dashboard.profile') }}"
           class="block p-3 rounded-xl hover:bg-gray-100 transition">
            👤 پروفایل
        </a>

        @if(auth()->user()->type == 'company')
            <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                📁 پروژه‌های من
            </a>

        @elseif(auth()->user()->type == 'manufacturer')
            <!-- Coming soon features: محصولات، برندها -->

        @elseif(auth()->user()->type == 'store')
            <!-- Coming soon features: محصولات، برندها -->

        @elseif(auth()->user()->type == 'technician')
            <!-- Coming soon features: کارهای من، سوابق کاری -->

        @elseif(auth()->user()->type == 'employer')
            <a href="{{ route('dashboard.projects.create') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                ➕ ثبت پروژه جدید
            </a>

            <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                📁 پروژه‌های من
            </a>
        @endif

        <hr class="my-5">

        <!-- Coming soon: پیام‌ها و تنظیمات -->

    </nav>

</aside>

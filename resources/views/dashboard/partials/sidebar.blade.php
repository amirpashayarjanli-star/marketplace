@php
    $user = auth()->user();
    $wizard = \App\Services\ProfileWizard::for($user);
    $isApproved = $user->status === 'approved';
@endphp

<aside class="w-72 bg-white shadow-lg min-h-screen p-5">

    <h2 class="text-2xl font-bold mb-8">
        <span class="text-blue-600">
            آسانسور
        </span>
        <span class="text-yellow-500">
            پرو
        </span>
    </h2>


    {{-- وضعیت پروفایل --}}

    @unless($isApproved)

        <a href="{{ route('profile.wizard') }}"
           class="block mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 hover:border-blue-400 transition">

            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold text-blue-900">تکمیل پروفایل</span>
                <span class="text-sm font-black text-blue-700">{{ $wizard->percentComplete() }}٪</span>
            </div>

            <div class="h-2 rounded-full bg-blue-200 overflow-hidden">
                <div class="h-full rounded-full bg-blue-600"
                     style="width: {{ $wizard->percentComplete() }}%"></div>
            </div>

            <p class="mt-2 text-xs text-blue-800">
                @if($user->status === 'pending')
                    در انتظار تایید مدیر
                @elseif($user->status === 'rejected')
                    تایید نشد
                @else
                    تا تایید نشوید در سایت دیده نمی‌شوید
                @endif
            </p>

        </a>

    @endunless


    <nav class="space-y-2">

        <a href="{{ route('dashboard') }}"
           class="block p-3 rounded-xl hover:bg-gray-100 transition {{ $isApproved ? '' : 'opacity-40 pointer-events-none' }}">
            🏠 داشبورد
        </a>

        <a href="{{ route('profile.wizard') }}"
           class="block p-3 rounded-xl hover:bg-gray-100 transition">
            👤 پروفایل
        </a>


        @if($isApproved)

            @if($user->type == 'company')

                <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    📁 پروژه‌های من
                </a>

                <a href="{{ route('dashboard.bids') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    🔨 پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    💰 کیف پول
                </a>

            @elseif($user->type == 'employer')

                <a href="{{ route('dashboard.projects.create') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    ➕ ثبت پروژه جدید
                </a>

                <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    📁 پروژه‌های من
                </a>

                <a href="{{ route('dashboard.auctions') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    🔨 مزایده‌های من
                </a>

                <a href="{{ route('dashboard.auctions.create') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    ➕ مزایده جدید
                </a>

            @elseif($user->type == 'technician')

                <a href="{{ route('service.jobs') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    🛠️ کارهای پروسرویس
                </a>

                <a href="{{ route('dashboard.bids') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    🔨 پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    💰 کیف پول
                </a>

            @elseif($user->type == 'manufacturer')

                <a href="{{ route('dashboard.bids') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    🔨 پیشنهادهای مزایده
                </a>

                <a href="{{ route('wallet') }}" class="block p-3 rounded-xl hover:bg-gray-100 transition">
                    💰 کیف پول
                </a>

            @endif

        @endif


        <hr class="my-5">


        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-right p-3 rounded-xl hover:bg-red-50 text-red-600 transition">
                🚪 خروج
            </button>
        </form>


    </nav>

</aside>

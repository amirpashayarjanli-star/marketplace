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
           class="block p-3 rounded-xl hover:bg-gray-100">

            🏠 داشبورد

        </a>



        <a href="{{ route('dashboard.profile') }}"
           class="block p-3 rounded-xl hover:bg-gray-100">

            👤 پروفایل

        </a>





        @if(auth()->user()->type == 'company')


            <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 پروژه‌های من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                🛠 خدمات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📩 درخواست‌ها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📄 استعلام‌ها

            </a>




        @elseif(auth()->user()->type == 'manufacturer')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📦 محصولات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                🏷 برندها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📁 پروژه‌ها

            </a>





        @elseif(auth()->user()->type == 'store')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📦 محصولات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                🏷 برندها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                ⭐ نظرات

            </a>





        @elseif(auth()->user()->type == 'technician')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                🔧 کارهای من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                📁 سوابق کاری

            </a>





        @elseif(auth()->user()->type == 'employer')


            <a href="{{ route('dashboard.projects.create') }}" class="block p-3 rounded-xl hover:bg-gray-100">

                ➕ ثبت پروژه جدید

            </a>


            <a href="{{ route('dashboard.projects') }}" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 پروژه‌های من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

                🏢 شرکت‌های پیشنهادی

            </a>


        @endif







        <hr class="my-5">





        <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

            💬 پیام‌ها

        </a>




        <a href="#" class="block p-3 rounded-xl hover:bg-gray-100" title="درحال تکمیل">

            ⚙ تنظیمات

        </a>



    </nav>


</aside>

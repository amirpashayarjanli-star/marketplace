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


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 پروژه‌های من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                🛠 خدمات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📩 درخواست‌ها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📄 استعلام‌ها

            </a>




        @elseif(auth()->user()->type == 'manufacturer')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📦 محصولات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                🏷 برندها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 پروژه‌ها

            </a>





        @elseif(auth()->user()->type == 'store')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📦 محصولات

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                🏷 برندها

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                ⭐ نظرات

            </a>





        @elseif(auth()->user()->type == 'technician')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                🔧 کارهای من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 سوابق کاری

            </a>





        @elseif(auth()->user()->type == 'employer')


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                ➕ ثبت پروژه جدید

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                📁 پروژه‌های من

            </a>


            <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

                🏢 شرکت‌های پیشنهادی

            </a>


        @endif







        <hr class="my-5">





        <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

            💬 پیام‌ها

        </a>




        <a href="#" class="block p-3 rounded-xl hover:bg-gray-100">

            ⚙ تنظیمات

        </a>



    </nav>


</aside>

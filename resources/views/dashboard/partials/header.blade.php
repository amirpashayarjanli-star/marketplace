<header class="bg-white shadow-sm p-5 flex items-center justify-between">


    <div>

        <h3 class="text-xl font-bold">

            سلام،
            {{ auth()->user()->name }}

            👋

        </h3>


        <p class="text-gray-500 text-sm mt-1">

            به داشبورد آسانسور پرو خوش آمدید

        </p>


    </div>




    <div class="flex items-center gap-5">


        <button class="relative text-xl">

            🔔

            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2">

                3

            </span>

        </button>





        <div class="bg-gray-100 px-4 py-2 rounded-xl">


            <span class="font-bold">

                {{ auth()->user()->type }}

            </span>


        </div>




        <form method="POST" action="/logout">

            @csrf

            <button class="text-red-500">

                خروج

            </button>


        </form>


    </div>



</header>

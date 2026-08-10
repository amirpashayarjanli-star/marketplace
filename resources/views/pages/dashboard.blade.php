@extends('layouts.app')

@section('title', 'داشبورد |  آسانسور پرو')


@section('content')

<section class="section">

<div class="container-app">


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- Profile Card --}}
        <div class="glass radius-lg p-6">


            <div class="text-center">


                <div class="w-20 h-20 mx-auto rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold">

                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                </div>


                <h2 class="mt-4 text-xl font-bold">

                    {{ auth()->user()->name }}

                </h2>


                <p class="text-muted mt-2">

                    {{ auth()->user()->email }}

                </p>



                <span class="inline-block mt-4 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm">


                    @switch(auth()->user()->type)

                        @case('company')
                            شرکت آسانسوری
                        @break

                        @case('manufacturer')
                            تولیدکننده
                        @break

                        @case('store')
                            فروشگاه
                        @break

                        @case('technician')
                            تکنسین
                        @break

                        @case('employer')
                            کارفرما
                        @break

                        @default
                            کاربر

                    @endswitch


                </span>


            </div>


        </div>





        {{-- Stats --}}

        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">


            <div class="glass radius-lg p-6">

                <h3 class="text-muted">
                    پروژه‌ها
                </h3>

                <strong class="text-3xl block mt-3">
                    0
                </strong>

            </div>



            <div class="glass radius-lg p-6">

                <h3 class="text-muted">
                    درخواست‌ها
                </h3>

                <strong class="text-3xl block mt-3">
                    0
                </strong>

            </div>



            <div class="glass radius-lg p-6">

                <h3 class="text-muted">
                    پیام‌ها
                </h3>

                <strong class="text-3xl block mt-3">
                    0
                </strong>

            </div>



        </div>



    </div>




    {{-- Quick Menu --}}

    <div class="glass radius-lg p-8 mt-8">


        <h2 class="text-xl font-bold mb-6">

            دسترسی سریع

        </h2>



        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


            <a href="/" class="glass radius-md p-5 text-center hover-lift">

                خانه

            </a>


            <a href="#" class="glass radius-md p-5 text-center hover-lift">

                پروفایل

            </a>


            <a href="#" class="glass radius-md p-5 text-center hover-lift">

                پیام‌ها

            </a>


            <a href="#" class="glass radius-md p-5 text-center hover-lift">

                تنظیمات

            </a>


        </div>


    </div>



</div>

</section>


@endsection

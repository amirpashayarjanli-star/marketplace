@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-10">

    <div class="w-full max-w-md bg-white rounded-2xl shadow p-8">


        <div class="text-center mb-8">

            <h1 class="text-2xl font-bold">
                ورود به حساب کاربری
            </h1>

            <p class="text-gray-500 mt-2">
                برای ورود شماره موبایل خود را وارد کنید
            </p>

        </div>



        @if($errors->any())

            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">

                {{ $errors->first() }}

            </div>

        @endif



        <form method="POST" action="{{ route('login') }}">

            @csrf



            <div class="mb-4">

                <label class="block mb-2">
                    شماره موبایل
                </label>


                <input

                    type="text"

                    name="mobile"

                    value="{{ old('mobile') }}"

                    placeholder="09123456789"

                    class="w-full border rounded-xl px-4 py-3"

                    required

                >

            </div>



            <div class="mb-6">

                <label class="block mb-2">
                    رمز عبور
                </label>


                <input

                    type="password"

                    name="password"

                    placeholder="رمز عبور"

                    class="w-full border rounded-xl px-4 py-3"

                    required

                >

            </div>



            <button

                type="submit"

                class="w-full bg-blue-600 text-white rounded-xl py-3"

            >

                مرحله بعد

            </button>


        </form>




        <div class="text-center mt-6 text-gray-600">


            آیا حساب کاربری ندارید؟

            <a

                href="{{ route('register') }}"

                class="text-blue-600 font-bold"

            >

                ثبت نام

            </a>


        </div>



    </div>

</div>


@endsection

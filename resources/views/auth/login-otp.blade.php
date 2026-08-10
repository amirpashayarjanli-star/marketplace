@extends('layouts.app')


@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100">


    <div class="bg-white rounded-2xl shadow p-8 w-full max-w-md">


        <h1 class="text-2xl font-bold text-center mb-4">

            تایید شماره موبایل

        </h1>



        <p class="text-center text-gray-500 mb-6">

            کد ارسال شده را وارد کنید

        </p>



        @if($errors->any())

            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">

                {{ $errors->first() }}

            </div>

        @endif



        <form method="POST" action="{{ route('login.otp') }}">

            @csrf



            <input

                type="text"

                name="code"

                maxlength="5"

                placeholder="12345"

                class="w-full border rounded-xl px-4 py-3 text-center text-xl tracking-widest"

                required

            >



            <button

                class="w-full mt-5 bg-blue-600 text-white py-3 rounded-xl"

            >

                تایید و ورود

            </button>


        </form>



    </div>


</div>


@endsection

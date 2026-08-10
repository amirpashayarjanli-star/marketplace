@extends('layouts.app')


@section('content')


<div class="min-h-screen flex items-center justify-center bg-gray-100">


<div class="bg-white rounded-2xl shadow p-8 w-full max-w-lg">


<h1 class="text-2xl font-bold text-center mb-3">

اطلاعات تکنسین

</h1>


<p class="text-gray-500 text-center mb-6">

اطلاعات تخصصی خود را وارد کنید

</p>



@if($errors->any())

<div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">

{{ $errors->first() }}

</div>

@endif




<form method="POST" action="/register/profile">

@csrf



<div class="mb-4">

<label class="block mb-2">

نام و نام خانوادگی

</label>


<input

type="text"

name="name"

value="{{ auth()->user()->name }}"

class="w-full border rounded-xl p-3"

required

>

</div>




<div class="mb-4">

<label class="block mb-2">

شهر فعالیت

</label>


<input

type="text"

name="city"

class="w-full border rounded-xl p-3"

placeholder="قم"

required

>

</div>




<div class="mb-4">

<label class="block mb-2">

تخصص‌ها

</label>


<input

type="text"

name="skills"

class="w-full border rounded-xl p-3"

placeholder="نصب، سرویس، تعمیرات"

required

>

</div>




<div class="mb-4">

<label class="block mb-2">

سابقه کار (سال)

</label>


<input

type="number"

name="experience"

class="w-full border rounded-xl p-3"

placeholder="5"

>

</div>




<div class="mb-6">

<label class="block mb-2">

توضیحات

</label>


<textarea

name="description"

class="w-full border rounded-xl p-3"

rows="4"

></textarea>


</div>




<button

class="w-full bg-blue-600 text-white rounded-xl py-3"

>

ثبت اطلاعات و ارسال برای تایید

</button>



</form>


</div>


</div>


@endsection

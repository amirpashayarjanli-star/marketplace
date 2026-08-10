@extends('layouts.app')


@section('content')


<div class="min-h-screen flex items-center justify-center bg-gray-100">


<div class="bg-white rounded-2xl shadow p-8 w-full max-w-lg">


<h1 class="text-2xl font-bold text-center mb-3">

اطلاعات کارفرما

</h1>


<p class="text-gray-500 text-center mb-6">

اطلاعات پروژه و مجموعه خود را وارد کنید

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

شهر

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

شماره تماس

</label>


<input

type="text"

name="phone"

class="w-full border rounded-xl p-3"

>

</div>




<div class="mb-4">

<label class="block mb-2">

نوع درخواست

</label>


<select

name="request_type"

class="w-full border rounded-xl p-3"

>


<option value="new_installation">

نصب آسانسور جدید

</option>


<option value="repair">

تعمیرات

</option>


<option value="service">

سرویس و نگهداری

</option>


</select>


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

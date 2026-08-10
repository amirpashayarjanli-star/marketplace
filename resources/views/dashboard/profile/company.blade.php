@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

پروفایل شرکت

</h1>





<div class="bg-white rounded-2xl shadow p-6">



@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">

{{ session('success') }}

</div>

@endif





@if($profile)



<form method="POST" action="{{ route('dashboard.profile.update') }}">

@csrf



<div class="grid grid-cols-1 md:grid-cols-2 gap-5">



<div>

<label class="block mb-2">

نام شرکت

</label>


<input

type="text"

name="name"

value="{{ $profile->name }}"

class="w-full border rounded-xl p-3"

>

</div>





<div>

<label class="block mb-2">

مدیر شرکت

</label>


<input

type="text"

name="manager_name"

value="{{ $profile->manager_name }}"

class="w-full border rounded-xl p-3"

>

</div>







<div>

<label class="block mb-2">

شماره تماس

</label>


<input

type="text"

name="phone"

value="{{ $profile->phone }}"

class="w-full border rounded-xl p-3"

>

</div>







<div>

<label class="block mb-2">

شهر

</label>


<input

type="text"

name="city"

value="{{ $profile->city }}"

class="w-full border rounded-xl p-3"

>

</div>





</div>







<div class="mt-5">


<label class="block mb-2">

توضیحات شرکت

</label>



<textarea

name="description"

rows="5"

class="w-full border rounded-xl p-3"

>{{ $profile->description }}</textarea>


</div>







<button

class="mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl"

>

ذخیره تغییرات

</button>



</form>



@else


<div class="text-gray-500">

پروفایل شرکت یافت نشد.

</div>


@endif



</div>





@endsection

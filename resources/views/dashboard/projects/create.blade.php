@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

ثبت پروژه جدید

</h1>





<div class="bg-white rounded-2xl shadow p-6">



@if($errors->any())

<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">


<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>


</div>

@endif






<form method="POST" action="{{ route('dashboard.projects.store') }}">

@csrf





<div class="grid grid-cols-1 md:grid-cols-2 gap-5">





<div>

<label class="block mb-2">

عنوان پروژه

</label>


<input

type="text"

name="title"

class="w-full border rounded-xl p-3"

placeholder="مثلا نصب آسانسور برج مسکونی"

value="{{ old('title') }}"

>


</div>







<div>

<label class="block mb-2">

نوع پروژه

</label>



<select

name="type"

class="w-full border rounded-xl p-3"

>


<option value="">

انتخاب کنید

</option>


<option value="new_installation">

نصب آسانسور جدید

</option>


<option value="repair">

تعمیرات

</option>


<option value="service">

سرویس و نگهداری

</option>


<option value="upgrade">

بازسازی و ارتقا

</option>


</select>


</div>







<div>

<label class="block mb-2">

استان

</label>


<input

type="text"

name="province"

class="w-full border rounded-xl p-3"

value="{{ old('province') }}"

>


</div>







<div>

<label class="block mb-2">

شهر

</label>


<input

type="text"

name="city"

class="w-full border rounded-xl p-3"

value="{{ old('city') }}"

>


</div>




</div>







<div class="mt-5">


<label class="block mb-2">

توضیحات پروژه

</label>



<textarea

name="description"

rows="6"

class="w-full border rounded-xl p-3"

placeholder="توضیحات کامل پروژه..."

>{{ old('description') }}</textarea>



</div>







<button

class="mt-6 bg-blue-600 text-white px-8 py-3 rounded-xl"

>

ثبت پروژه

</button>




</form>



</div>





@endsection

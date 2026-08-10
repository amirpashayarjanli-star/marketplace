@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

داشبورد تولیدکننده

</h1>







<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">





<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

محصولات ثبت شده

</div>


<div class="text-4xl font-bold">

{{ $products ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

پروژه‌های مرتبط

</div>


<div class="text-4xl font-bold text-green-600">

{{ $projects ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

درخواست‌های همکاری

</div>


<div class="text-4xl font-bold text-blue-600">

{{ $inquiries ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">


<div class="text-gray-500 mb-3">

اعتبار برند

</div>


<div class="text-4xl font-bold">

{{ $manufacturer->rating ?? 0 }}

⭐

</div>


</div>






</div>









<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">






<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

پروژه‌های همکاری

</h2>



@if(($projects ?? 0) > 0)


<p class="text-green-600">

{{ $projects }} پروژه مرتبط دارید.

</p>


@else


<p class="text-gray-500">

هنوز پروژه‌ای برای شما ثبت نشده است.

</p>


@endif



</div>








<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

درخواست‌های ارسال شده

</h2>



@if(($inquiries ?? 0) > 0)


<p class="text-blue-600">

{{ $inquiries }} درخواست همکاری ارسال کرده‌اید.

</p>


@else


<p class="text-gray-500">

درخواستی ارسال نشده است.

</p>


@endif



</div>







</div>









<div class="bg-white rounded-2xl shadow p-6 mt-6">


<h2 class="text-xl font-bold mb-5">

اطلاعات تولیدکننده

</h2>





@if($manufacturer)


<div class="space-y-3">



<p>

<strong>
نام:
</strong>

{{ $manufacturer->name }}

</p>





<p>

<strong>
شهر:
</strong>

{{ $manufacturer->city ?? 'ثبت نشده' }}

</p>





<p>

<strong>
سابقه:
</strong>

{{ $manufacturer->experience ?? 0 }}

سال

</p>





</div>



@else


<p class="text-gray-500">

پروفایل تولیدکننده هنوز تکمیل نشده است.

</p>


@endif



</div>






@endsection

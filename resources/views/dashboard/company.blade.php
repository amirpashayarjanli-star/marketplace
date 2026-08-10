@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

داشبورد شرکت آسانسوری

</h1>






<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">





<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

پروژه‌های من

</div>


<div class="text-4xl font-bold">

{{ $projects ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

پروژه‌های فعال

</div>


<div class="text-4xl font-bold text-green-600">

{{ $activeProjects ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

درخواست‌های ارسال شده

</div>


<div class="text-4xl font-bold text-blue-600">

{{ $inquiries ?? 0 }}

</div>


</div>








<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

نظرات مشتریان

</div>


<div class="text-4xl font-bold">

{{ $reviews ?? 0 }}

</div>


</div>






</div>









<div class="bg-white rounded-2xl shadow p-6 mt-8">


<h2 class="text-xl font-bold mb-5">

اطلاعات شرکت

</h2>





@if($company)


<div class="space-y-3">


<p>

<strong>
نام شرکت:
</strong>

{{ $company->name }}

</p>





<p>

<strong>
شهر:
</strong>

{{ $company->city ?? 'ثبت نشده' }}

</p>





<p>

<strong>
سابقه:
</strong>

{{ $company->experience ?? 0 }}

سال

</p>





<p>

<strong>
توضیحات:
</strong>

{{ $company->description ?? 'ثبت نشده' }}

</p>



</div>



@else


<p class="text-gray-500">

پروفایل شرکت هنوز تکمیل نشده است.

</p>


@endif



</div>









<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">





<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

پروژه‌های اختصاص داده شده

</h2>



@if(($activeProjects ?? 0) > 0)


<p class="text-green-600">

{{ $activeProjects }} پروژه در حال همکاری دارید.

</p>


@else


<p class="text-gray-500">

هنوز پروژه‌ای به شرکت اختصاص داده نشده است.

</p>


@endif



</div>








<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

درخواست‌های همکاری

</h2>




@if(($inquiries ?? 0) > 0)


<p class="text-blue-600">

{{ $inquiries }} درخواست ارسال کرده‌اید.

</p>


@else


<p class="text-gray-500">

درخواستی ثبت نشده است.

</p>


@endif



</div>






</div>






@endsection

@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

داشبورد تکنسین

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

امتیاز کاری

</div>


<div class="text-4xl font-bold">

{{ $technician->rating ?? 0 }}

⭐

</div>


</div>






</div>









<div class="bg-white rounded-2xl shadow p-6 mt-8">


<h2 class="text-xl font-bold mb-5">

اطلاعات تکنسین

</h2>





@if($technician)



<div class="space-y-3">



<p>

<strong>
نام:
</strong>

{{ $technician->name }}

</p>





<p>

<strong>
شهر:
</strong>

{{ $technician->city ?? 'ثبت نشده' }}

</p>





<p>

<strong>
سابقه:
</strong>

{{ $technician->experience ?? 0 }}

سال

</p>





<p>

<strong>
توضیحات:
</strong>

{{ $technician->description ?? 'ثبت نشده' }}

</p>



</div>




@else


<p class="text-gray-500">

پروفایل تکنسین هنوز تکمیل نشده است.

</p>


@endif



</div>









<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">






<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

کارهای جاری

</h2>




@if(($activeProjects ?? 0) > 0)


<p class="text-green-600">

{{ $activeProjects }} پروژه فعال دارید.

</p>


@else


<p class="text-gray-500">

در حال حاضر کاری به شما اختصاص داده نشده است.

</p>


@endif



</div>








<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

سوابق کاری

</h2>



<p>

تعداد پروژه‌های انجام شده:

<strong>

{{ $projects ?? 0 }}

</strong>

</p>



<p class="mt-3">

تعداد تعمیرات:

<strong>

{{ $technician->repairs_count ?? 0 }}

</strong>

</p>



<p class="mt-3">

تعداد نظرات:

<strong>

{{ $reviews ?? 0 }}

</strong>

</p>



</div>






</div>






@endsection

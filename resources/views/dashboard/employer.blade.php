@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

داشبورد کارفرما

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

پروژه‌های باز

</div>


<div class="text-4xl font-bold text-yellow-600">

{{ $openProjects ?? 0 }}

</div>

</div>








<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

پروژه‌های اختصاص داده شده

</div>


<div class="text-4xl font-bold text-green-600">

{{ $assignedProjects ?? 0 }}

</div>

</div>








<div class="bg-white rounded-2xl shadow p-6">

<div class="text-gray-500 mb-3">

درخواست‌های جدید

</div>


<div class="text-4xl font-bold text-blue-600">

{{ $inquiries ?? 0 }}

</div>

</div>






</div>




{{-- پرو مزایده --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">


<a href="{{ route('dashboard.auctions') }}"
   class="bg-white rounded-2xl shadow p-6 block hover:shadow-lg transition">

<div class="text-gray-500 mb-3">

مزایده‌های در جریان

</div>


<div class="text-4xl font-bold text-purple-600">

{{ $activeAuctions ?? 0 }}

</div>

</a>




<a href="{{ route('dashboard.auctions') }}"
   class="bg-white rounded-2xl shadow p-6 block hover:shadow-lg transition">

<div class="text-gray-500 mb-3">

پیشنهادهای دریافتی

</div>


<div class="text-4xl font-bold text-purple-600">

{{ $auctionBids ?? 0 }}

</div>

</a>


</div>









<div class="bg-white rounded-2xl shadow p-6 mt-8">


<h2 class="text-xl font-bold mb-5">

اطلاعات کارفرما

</h2>





@if($employer)


<div class="space-y-3">


<p>

<strong>
نام:
</strong>

{{ $employer->name }}

</p>





<p>

<strong>
شهر:
</strong>

{{ $employer->city ?? 'ثبت نشده' }}

</p>





<p>

<strong>
توضیحات:
</strong>

{{ $employer->description ?? 'ثبت نشده' }}

</p>



</div>


@else


<p class="text-gray-500">

پروفایل کارفرما تکمیل نشده است.

</p>


@endif



</div>









<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">





<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

وضعیت پروژه‌ها

</h2>




<div class="space-y-3">


<p>

🟡 پروژه‌های باز:

<strong>

{{ $openProjects ?? 0 }}

</strong>

</p>





<p>

🟢 پروژه‌های در حال همکاری:

<strong>

{{ $assignedProjects ?? 0 }}

</strong>

</p>



</div>



</div>









<div class="bg-white rounded-2xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

درخواست‌های همکاری

</h2>



@if(($inquiries ?? 0) > 0)


<p class="text-blue-600">

{{ $inquiries }} درخواست جدید دارید.

</p>


@else


<p class="text-gray-500">

درخواستی وجود ندارد.

</p>


@endif



</div>






</div>







@endsection

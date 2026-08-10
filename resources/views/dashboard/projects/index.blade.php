@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

پروژه‌های من

</h1>





@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">

{{ session('success') }}

</div>

@endif





<div class="flex justify-between items-center mb-6">


<div>

تعداد پروژه‌ها:

<strong>

{{ $projects->count() }}

</strong>

</div>





@if(auth()->user()->type == 'employer')


<a href="{{ route('dashboard.projects.create') }}"

class="bg-blue-600 text-white px-5 py-3 rounded-xl">


➕ ثبت پروژه جدید


</a>


@endif



</div>








<div class="grid grid-cols-1 md:grid-cols-2 gap-6">





@forelse($projects as $project)





<div class="bg-white rounded-2xl shadow p-6">



<h2 class="text-xl font-bold mb-3">

{{ $project->title }}

</h2>





<div class="space-y-2 text-gray-600">



<p>

📍

{{ $project->province }}

-

{{ $project->city }}

</p>





<p>

نوع پروژه:

{{ $project->type }}

</p>





<p>

وضعیت:

@if($project->is_active)

<span class="text-green-600">

فعال

</span>

@else

<span class="text-red-600">

غیرفعال

</span>

@endif

</p>





</div>








<a href="{{ route('dashboard.projects.show',$project->id) }}"

class="inline-block mt-5 text-blue-600">


مشاهده جزئیات ←


</a>





</div>





@empty




<div class="bg-white rounded-2xl shadow p-6">


<p class="text-gray-500">

هنوز پروژه‌ای ثبت نشده است.

</p>



@if(auth()->user()->type == 'employer')


<a href="{{ route('dashboard.projects.create') }}"

class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-xl">


ثبت اولین پروژه


</a>


@endif



</div>




@endforelse





</div>







@endsection

@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">

جزئیات پروژه

</h1>





@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">

{{ session('success') }}

</div>

@endif






<div class="bg-white rounded-2xl shadow p-6">





<h2 class="text-2xl font-bold mb-5">

{{ $project->title }}

</h2>





<div class="space-y-3">


<p>
📍
{{ $project->province }}
-
{{ $project->city }}
</p>



<p>
🏗 نوع پروژه:
{{ $project->type }}
</p>




<div>

<p class="font-bold mb-2">

📝 توضیحات:

</p>


<div class="bg-gray-50 rounded-xl p-4">

{{ $project->description }}

</div>


</div>



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









<hr class="my-6">







@if(in_array(auth()->user()->type,[

'company',

'technician',

'manufacturer'

]))



<h3 class="text-xl font-bold mb-4">

🤝 درخواست همکاری

</h3>




<form method="POST"

action="{{ route('dashboard.projects.inquiry',$project->id) }}">


@csrf



<textarea

name="message"

class="w-full border rounded-xl p-3"

rows="4"

placeholder="پیام شما برای کارفرما..."

></textarea>




<button

class="mt-4 bg-blue-600 text-white px-6 py-3 rounded-xl"

>

ارسال درخواست

</button>



</form>



@endif










@if(auth()->id() == $project->employer?->user_id)



<h3 class="text-xl font-bold mt-8 mb-4">

📩 درخواست‌های همکاری

</h3>





@forelse($project->inquiries as $inquiry)



<div class="border rounded-xl p-5 mb-4">





<p>

نوع درخواست:

<strong>

{{ $inquiry->type }}

</strong>

</p>





<p class="mt-2">

پیام:

{{ $inquiry->message }}

</p>





<p class="mt-2">

وضعیت:

@if($inquiry->status == 'pending')

<span class="text-yellow-600">

در انتظار بررسی

</span>


@elseif($inquiry->status == 'accepted')

<span class="text-green-600">

تایید شده

</span>


@else

<span class="text-red-600">

رد شده

</span>


@endif

</p>








@if($inquiry->status == 'pending')



<div class="flex gap-3 mt-4">





<form method="POST"

action="{{ route('dashboard.projects.inquiry.accept',$inquiry->id) }}">

@csrf


<button

class="bg-green-600 text-white px-5 py-2 rounded-xl"

>

✅ قبول همکاری

</button>


</form>







<form method="POST"

action="{{ route('dashboard.projects.inquiry.reject',$inquiry->id) }}">

@csrf


<button

class="bg-red-600 text-white px-5 py-2 rounded-xl"

>

❌ رد درخواست

</button>


</form>




</div>



@endif





</div>



@empty


<p class="text-gray-500">

هنوز درخواست همکاری دریافت نشده است.

</p>



@endforelse



@endif






</div>





@endsection

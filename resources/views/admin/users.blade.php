@extends('layouts.app')


@section('content')


<div class="max-w-5xl mx-auto mt-10">


<h1 class="text-2xl font-bold mb-6">

کاربران در انتظار تایید

</h1>



@if(session('success'))

<div class="bg-green-100 p-3 rounded-xl mb-5">

{{ session('success') }}

</div>

@endif




<div class="bg-white rounded-xl shadow p-5">


@forelse($users as $user)


<div class="border-b py-5 flex justify-between items-center">


<div>


<h3 class="font-bold">

{{ $user->name }}

</h3>


<p>

موبایل:
{{ $user->mobile }}

</p>


<p>

نوع حساب:
{{ $user->type }}

</p>


</div>




<div class="flex gap-2">



<form method="POST"
action="{{ route('admin.users.approve',$user) }}">

@csrf


<button class="bg-green-600 text-white px-4 py-2 rounded-xl">

تایید

</button>


</form>





<form method="POST"
action="{{ route('admin.users.reject',$user) }}">

@csrf


<button class="bg-red-600 text-white px-4 py-2 rounded-xl">

رد

</button>


</form>



</div>


</div>



@empty


<p>

کاربر منتظر تایید وجود ندارد.

</p>


@endforelse



</div>


</div>


@endsection

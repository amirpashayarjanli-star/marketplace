@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

<h1 class="text-2xl font-bold mb-6">
نظرات منتظر تایید
</h1>

@if(session('success'))
<div class="bg-green-100 p-3 rounded-xl mb-5 text-green-800">
{{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow p-5">

@forelse($reviews as $review)

<div class="border-b py-5 space-y-3">

<div class="flex justify-between items-start">
<div class="flex-1">
<h3 class="font-bold text-lg">{{ $review->name }}</h3>
<p class="text-sm text-gray-600">
@if($review->reviewable)
{{ $review->reviewable->name }}
@else
(حذف شده)
@endif
</p>
<p class="text-xs text-gray-500 mt-1">
{{ $review->created_at->toJalaliDateString() }}
</p>
</div>
<div class="flex gap-1">
@for($i = 1; $i <= 5; $i++)
<x-ui.icon name="star" style="color: {{ $i <= $review->rating ? 'var(--gold)' : 'var(--border-strong)' }}" />
@endfor
</div>
</div>

<p class="text-gray-700 bg-gray-50 p-3 rounded-lg">
{{ $review->comment }}
</p>

<div class="flex gap-2 justify-end">
<form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
@csrf
<button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
<x-ui.icon name="check" class="ml-2" />تایید
</button>
</form>

<form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
@csrf
@method('DELETE')
<button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
<x-ui.icon name="trash" class="ml-2" />حذف
</button>
</form>
</div>

</div>

@empty

<p class="text-gray-500 py-8 text-center">
هیچ نظر منتظر تایید وجود ندارد.
</p>

@endforelse

</div>

</div>

@endsection

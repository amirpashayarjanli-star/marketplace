@extends('dashboard.layouts.dashboard')


@section('content')


<h1 class="text-3xl font-bold mb-6">مزایده‌ی جدید</h1>


@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
        <ul class="list-inside list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{ route('dashboard.auctions.store') }}"
      class="bg-white rounded-2xl shadow p-6 max-w-2xl space-y-5">
    @csrf

    <div>
        <label class="block mb-1 font-semibold text-gray-700">عنوان مزایده</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="w-full rounded-xl border border-gray-300 px-4 py-2">
    </div>

    <div>
        <label class="block mb-1 font-semibold text-gray-700">نوع کار</label>
        <select name="scope" required class="w-full rounded-xl border border-gray-300 px-4 py-2">
            @foreach($scopes as $key => $label)
                <option value="{{ $key }}" @selected(old('scope') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    @if($projects->count())
        <div>
            <label class="block mb-1 font-semibold text-gray-700">اتصال به پروژه (اختیاری)</label>
            <select name="project_id" class="w-full rounded-xl border border-gray-300 px-4 py-2">
                <option value="">— بدون پروژه —</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>{{ $project->title }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">استان</label>
            <input type="text" name="province" value="{{ old('province') }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">شهر</label>
            <input type="text" name="city" value="{{ old('city') }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2">
        </div>
    </div>

    <div>
        <label class="block mb-1 font-semibold text-gray-700">شرح پروژه</label>
        <textarea name="description" rows="5" required
                  class="w-full rounded-xl border border-gray-300 px-4 py-2">{{ old('description') }}</textarea>
    </div>

    <div>
        <label class="block mb-1 font-semibold text-gray-700">مشخصات فنی (اختیاری)</label>
        <textarea name="specs" rows="3" placeholder="تعداد توقف، ظرفیت، نوع درب و ..."
                  class="w-full rounded-xl border border-gray-300 px-4 py-2">{{ old('specs') }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold text-gray-700">سقف بودجه (تومان، اختیاری)</label>
            <input type="number" name="budget_max" value="{{ old('budget_max') }}" min="0"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold text-gray-700">پایان مهلت</label>
            <input type="date" name="ends_on" value="{{ old('ends_on') }}" required
                   min="{{ $minDate }}" max="{{ $maxDate }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2">
        </div>
    </div>

    <div class="rounded-xl border border-amber-300 bg-amber-50 p-4">
        <p class="mb-2 font-bold text-amber-900">☎️ مرحله‌ی بعد: مشاوره‌ی تخصصی</p>
        <p class="text-sm text-amber-800">
            پس از ثبت، کارشناسان ما پروژه‌ی شما را بررسی می‌کنند تا شرح و برآوردش
            درست تنظیم شود و شرکت‌های معتبر پیشنهاد بدهند. شماره‌ی تماس:
            <a href="tel:{{ config('proauction.consultation_phone') }}"
               class="font-black text-amber-900 underline">{{ config('proauction.consultation_phone') }}</a>
            @if((int) config('proauction.consultation_fee', 0) > 0)
                <br>هزینه‌ی مشاوره: <strong>{{ number_format(config('proauction.consultation_fee')) }} تومان</strong>
                (از کیف‌پول، پس از تماس)
            @endif
        </p>
        <p class="mt-2 text-xs text-amber-700">
            پیشنهادها عمومی است و کمترین پیشنهاد، پیشرو خواهد بود.
        </p>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold">
        ثبت مزایده
    </button>

</form>


@endsection

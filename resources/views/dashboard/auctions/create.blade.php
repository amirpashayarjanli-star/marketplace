@extends('dashboard.layouts.dashboard')


@section('content')


<div class="auction-board-head">
    <div>
        <h1>مزایده‌ی جدید</h1>
        <p>پروژه‌تان را ثبت کنید تا شرکت‌ها و تکنسین‌ها پیشنهاد قیمت بدهند.</p>
    </div>
</div>


@if($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{ route('dashboard.auctions.store') }}" class="card auction-create-form">
    @csrf

    <div class="field">
        <label class="field-label" for="auction-title">عنوان مزایده</label>
        <input id="auction-title" type="text" name="title" class="input"
               value="{{ old('title') }}" required>
    </div>

    <div class="field">
        <label class="field-label" for="auction-scope">نوع کار</label>
        <select id="auction-scope" name="scope" class="input" required>
            @foreach($scopes as $key => $label)
                <option value="{{ $key }}" @selected(old('scope') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    @if($projects->count())
        <div class="field">
            <label class="field-label" for="auction-project">اتصال به پروژه (اختیاری)</label>
            <select id="auction-project" name="project_id" class="input">
                <option value="">— بدون پروژه —</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>
                        {{ $project->title }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="field-row">
        <div class="field">
            <label class="field-label" for="auction-province">استان</label>
            <input id="auction-province" type="text" name="province" class="input"
                   value="{{ old('province') }}">
        </div>
        <div class="field">
            <label class="field-label" for="auction-city">شهر</label>
            <input id="auction-city" type="text" name="city" class="input" value="{{ old('city') }}">
        </div>
    </div>

    <div class="field">
        <label class="field-label" for="auction-description">شرح پروژه</label>
        <textarea id="auction-description" name="description" rows="5" class="input"
                  required>{{ old('description') }}</textarea>
    </div>

    <div class="field">
        <label class="field-label" for="auction-specs">مشخصات فنی (اختیاری)</label>
        <textarea id="auction-specs" name="specs" rows="3" class="input"
                  placeholder="تعداد توقف، ظرفیت، نوع درب و ...">{{ old('specs') }}</textarea>
    </div>

    <div class="field-row">
        <div class="field">
            <label class="field-label" for="auction-budget">سقف بودجه (تومان، اختیاری)</label>
            <input id="auction-budget" type="number" name="budget_max" class="input"
                   value="{{ old('budget_max') }}" min="0">
        </div>
        <div class="field">
            <label class="field-label" for="auction-ends">پایان مهلت</label>
            <input id="auction-ends" type="date" name="ends_on" class="input"
                   value="{{ old('ends_on') }}" required
                   min="{{ $minDate }}" max="{{ $maxDate }}">
        </div>
    </div>

    <div class="auction-note">
        <strong>☎️ مرحله‌ی بعد: مشاوره‌ی تخصصی</strong>
        <br>
        پس از ثبت، کارشناسان ما پروژه‌ی شما را بررسی می‌کنند تا شرح و برآوردش
        درست تنظیم شود و شرکت‌های معتبر پیشنهاد بدهند. شماره‌ی تماس:
        <a href="tel:{{ config('proauction.consultation_phone') }}">{{ config('proauction.consultation_phone') }}</a>
        @if((int) config('proauction.consultation_fee', 0) > 0)
            <br>هزینه‌ی مشاوره: <strong>{{ number_format(config('proauction.consultation_fee')) }} تومان</strong>
            (از کیف‌پول، پس از تماس)
        @endif
        <br>
        پیشنهادها عمومی است و کمترین پیشنهاد، پیشرو خواهد بود.
    </div>

    <button type="submit" class="btn btn-primary">ثبت مزایده</button>

</form>


@endsection

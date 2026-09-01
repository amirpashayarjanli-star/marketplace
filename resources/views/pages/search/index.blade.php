@extends('layouts.app')


@section('title', $q !== '' ? "جستجوی «{$q}» | آسانسور پرو" : 'جستجو | آسانسور پرو')


@section('content')


@include('sections.header-inner')



<main class="directory-page">


    <section class="directory-top">

        <h1>
            @if($q !== '')
                نتایج جستجو برای «{{ $q }}»
            @else
                جستجو در آسانسور پرو
            @endif
        </h1>

        <p>
            @if($q !== '')
                {{ $totalResults }} نتیجه پیدا شد
            @else
                نام شرکت، تولیدکننده، فروشگاه، تکنسین یا پروژه‌ای که دنبالشی رو بنویس
            @endif
        </p>

    </section>


    <div class="container-app">

        <form method="GET" action="{{ route('search') }}" class="relative" style="max-width:560px;margin:0 auto 2.5rem">

            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="جستجو در آسانسور پرو..."
                class="input header-search-input w-full rounded-full"
                autofocus>

            <button type="submit" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-blue-600 transition">
                <x-ui.icon name="search" :size="20" />
            </button>

        </form>


        @if($q === '')

            <div class="slider-empty">
                <x-ui.icon name="magnifying-glass" />
                <h3>برای شروع، عبارتی رو جستجو کن.</h3>
            </div>

        @elseif($totalResults === 0)

            <div class="slider-empty">
                <x-ui.icon name="folder-open" />
                <h3>چیزی برای «{{ $q }}» پیدا نشد.</h3>
            </div>

        @else

            @if($companies->isNotEmpty())
                <x-section-title
                    title="شرکت‌های آسانسوری"
                    url="{{ route('companies.index', ['search' => $q]) }}"
                    button="مشاهده همه"
                />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @foreach($companies as $company)
                        <a href="{{ route('company.profile', $company->slug) }}" class="block">
                            <x-card-company :company="$company" />
                        </a>
                    @endforeach
                </div>
            @endif


            @if($manufacturers->isNotEmpty())
                <x-section-title
                    title="تولیدکنندگان"
                    url="{{ route('manufacturers.index', ['search' => $q]) }}"
                    button="مشاهده همه"
                />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @foreach($manufacturers as $manufacturer)
                        <a href="{{ route('manufacturer.profile', $manufacturer->slug) }}" class="block">
                            <x-card-manufacturer :manufacturer="$manufacturer" />
                        </a>
                    @endforeach
                </div>
            @endif


            @if($stores->isNotEmpty())
                <x-section-title
                    title="فروشگاه‌ها"
                    url="{{ route('stores.index', ['search' => $q]) }}"
                    button="مشاهده همه"
                />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @foreach($stores as $store)
                        <a href="{{ route('store.profile', $store->slug) }}" class="block">
                            <x-card-store :store="$store" />
                        </a>
                    @endforeach
                </div>
            @endif


            @if($technicians->isNotEmpty())
                <x-section-title
                    title="تکنسین‌ها"
                    url="{{ route('technicians.index', ['search' => $q]) }}"
                    button="مشاهده همه"
                />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    @foreach($technicians as $technician)
                        <a href="{{ route('technician.profile', $technician->slug) }}" class="block">
                            <x-card-technician :technician="$technician" />
                        </a>
                    @endforeach
                </div>
            @endif


            @if($projects->isNotEmpty())
                <x-section-title
                    title="پروژه‌ها"
                    url="{{ route('projects.index', ['search' => $q]) }}"
                    button="مشاهده همه"
                />
                <div class="company-grid mb-12">
                    @foreach($projects as $project)
                        <x-directory.project-card :project="$project" />
                    @endforeach
                </div>
            @endif

        @endif

    </div>


</main>



@include('sections.footer')


@endsection

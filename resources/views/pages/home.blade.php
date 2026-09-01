@extends('layouts.app')

@section('title', 'آسانسور پرو')

@section('content')

{{-- هدر: بیرون و بالای هیرو، با اسکرول بالای صفحه sticky می‌مونه.
     مستقیم فرزند main هست تا sticky در کل صفحه کار کنه، نه فقط داخل یه wrapper کوتاه. --}}

<div class="home-page-header">

    @include('sections.header')

</div>


<main>

    <div class="desktop-home">
        @include('sections.hero')
    </div>

    <div class="mobile-home">
        @include('mobile.hero')
    </div>

    <div class="desktop-home">
        @include('sections.trust-bar')
    </div>


    @include('sections.quick-access')


    @include('sections.collaboration')


    @include('sections.top-companies', [
        'topCompanies' => $topCompanies
    ])


    @include('sections.top-manufacturers', [
        'topManufacturers' => $topManufacturers
    ])


    @include('sections.top-stores', [
        'topStores' => $topStores
    ])


    @include('sections.top-technicians', [
        'topTechnicians' => $topTechnicians
    ])


    @include('sections.latest-auctions', [
        'latestAuctions' => $latestAuctions
    ])


    @include('sections.latest-projects', [
        'latestProjects' => $latestProjects
    ])


    @include('sections.latest-inquiries', [
        'latestInquiries' => $latestInquiries
    ])


    @include('sections.articles')


</main>


@include('sections.footer')


@endsection

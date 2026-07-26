@extends('layouts.app')

@section('title', 'آسانسور پرو')

@section('content')

<main>

    <div class="desktop-home">
        @include('sections.hero')
    </div>

    <div class="mobile-home">
        @include('mobile.hero')
    </div>

    <div class="desktop-only">
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

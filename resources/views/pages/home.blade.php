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

    @include('sections.top-companies')

    @include('sections.top-manufacturers')

    @include('sections.top-stores')

    @include('sections.latest-projects')

    @include('sections.latest-inquiries')

    @include('sections.articles')


</main>


@include('sections.footer')


@endsection

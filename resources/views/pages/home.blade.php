@extends('layouts.app')

@section('title', 'آسانسور پرو')

@section('content')

@include('sections.header')

<main class="pt-24">

    @include('sections.hero')

    @include('sections.trust-bar')

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
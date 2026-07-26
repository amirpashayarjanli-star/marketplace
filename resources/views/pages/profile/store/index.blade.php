@extends('layouts.app')


@section('title','پروفایل فروشگاه قطعات آسانسور')



@section('content')



@include('sections.header-inner')



<main class="profile-page">



    {{-- Hero --}}

    @include('pages.profile.store.sections.hero')




    {{-- Stats --}}

    @include('pages.profile.store.sections.stats')




    {{-- About --}}

    @include('pages.profile.store.sections.about')




    {{-- Products --}}

    @include('pages.profile.store.sections.products')




    {{-- Brands --}}

    @include('pages.profile.store.sections.brands')




    {{-- Reviews --}}

    @include('pages.profile.store.sections.reviews')




    {{-- Contact --}}

    @include('pages.profile.store.sections.contact')




</main>




@include('sections.footer')



@endsection

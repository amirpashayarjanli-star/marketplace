@extends('layouts.app')


@section('title','پروفایل تولیدکننده تجهیزات آسانسور')



@section('content')



@include('sections.header-inner')



<main class="profile-page">



    {{-- Hero --}}

    @include('pages.profile.manufacturer.sections.hero')




    {{-- Stats --}}

    @include('pages.profile.manufacturer.sections.stats')




    {{-- About --}}

    @include('pages.profile.manufacturer.sections.about')




    {{-- Products --}}

    @include('pages.profile.manufacturer.sections.products')




    {{-- Projects --}}

    @include('pages.profile.manufacturer.sections.projects')




    {{-- Reviews --}}

    @include('pages.profile.manufacturer.sections.reviews')




    {{-- Contact --}}

    @include('pages.profile.manufacturer.sections.contact')




</main>





@include('sections.footer')



@endsection

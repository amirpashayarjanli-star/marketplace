@extends('layouts.app')


@section('title','پروفایل شرکت آسانسوری')



@section('content')



@include('sections.header-inner')



<main class="profile-page">



    {{-- Profile Hero --}}

    @include('pages.profile.company.sections.hero')




    {{-- Stats --}}

    @include('pages.profile.company.sections.stats')




    {{-- About --}}

    @include('pages.profile.company.sections.about')




    {{-- Services --}}

    @include('pages.profile.company.sections.services')




    {{-- Projects --}}

    @include('pages.profile.company.sections.projects')




    {{-- Reviews --}}

    @include('pages.profile.company.sections.reviews')




    {{-- Contact --}}

    @include('pages.profile.company.sections.contact')




</main>




@include('sections.footer')



@endsection

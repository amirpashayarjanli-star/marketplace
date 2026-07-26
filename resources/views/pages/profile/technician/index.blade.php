@extends('layouts.app')


@section('title','پروفایل تکنسین آسانسور')



@section('content')



@include('sections.header-inner')



<main class="profile-page">



    {{-- Hero --}}

    @include('pages.profile.technician.sections.hero')




    {{-- Stats --}}

    @include('pages.profile.technician.sections.stats')




    {{-- About --}}

    @include('pages.profile.technician.sections.about')




    {{-- Skills --}}

    @include('pages.profile.technician.sections.skills')




    {{-- Projects --}}

    @include('pages.profile.technician.sections.projects')




    {{-- Reviews --}}

    @include('pages.profile.technician.sections.reviews')




    {{-- Contact --}}

    @include('pages.profile.technician.sections.contact')




</main>




@include('sections.footer')



@endsection

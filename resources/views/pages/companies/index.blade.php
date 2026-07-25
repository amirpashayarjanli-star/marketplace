@extends('layouts.app')


@section('title','شرکت های آسانسوری')


@section('content')


@include('sections.header-inner')



<main class="directory-page">



    <section class="directory-top">


        <h1>
            شرکت‌های آسانسوری ایران
        </h1>


        <p>
            بهترین شرکت‌های آسانسوری را پیدا کنید
        </p>


    </section>




    <x-directory.filter-box />




    <div class="company-grid">


        @foreach($companies as $company)


            <x-directory.company-card
                :company="$company" />


        @endforeach


    </div>



</main>



@include('sections.footer')


@endsection

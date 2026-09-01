@extends('layouts.app')


@section('title','شرکت های آسانسوری')


@section('content')


@include('sections.header-inner')



<main class="directory-page">


    <div class="container-app">

        <section class="directory-top">


            <h1>
                شرکت‌های آسانسوری ایران
            </h1>


            <p>
                بهترین شرکت‌های آسانسوری را پیدا کنید
            </p>


        </section>




        <x-directory.filter-box
            register="ثبت شرکت"
            search="جستجوی شرکت آسانسوری..."
        />




        <div class="company-grid">


            @foreach($companies as $company)


                <x-directory.company-card
                    :company="$company" />


            @endforeach


        </div>

    </div>


</main>



@include('sections.footer')


@endsection

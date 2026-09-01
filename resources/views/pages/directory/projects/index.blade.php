@extends('layouts.app')


@section('title','پروژه‌های آسانسور')


@section('content')



@include('sections.header-inner')



<main class="directory-page">


    <div class="container-app">

    <section class="directory-top">


        <h1>

            پروژه‌های آسانسور ایران

        </h1>



        <p>

            پروژه‌های اجرا شده و در حال اجرای آسانسور را مشاهده کنید

        </p>


    </section>







    <x-directory.filter-box

        register="ثبت پروژه"

        search="جستجوی پروژه..."

    />









    <div class="company-grid">



        @foreach($projects as $project)



            <x-directory.project-card

                :project="$project"

            />



        @endforeach




    </div>

    </div>


</main>





@include('sections.footer')



@endsection

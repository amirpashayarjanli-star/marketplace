@extends('layouts.app')


@section('title','تکنسین‌های آسانسور')


@section('content')



@include('sections.header-inner')



<main class="directory-page">



    <section class="directory-top">


        <h1>

            تکنسین‌های آسانسور ایران

        </h1>



        <p>

            تکنسین‌های متخصص آسانسور را پیدا کنید

        </p>


    </section>






    <x-directory.filter-box

        register="ثبت تکنسین"

    />







    <div class="company-grid">



        @foreach($technicians as $technician)



            <x-directory.technician-card

                :technician="$technician"

            />



        @endforeach




    </div>





</main>





@include('sections.footer')



@endsection

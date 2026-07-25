@extends('layouts.app')


@section('title','تولیدکنندگان تجهیزات آسانسور')


@section('content')


@include('sections.header-inner')



<main class="directory-page">



    <section class="directory-top">


        <h1>

            تولیدکنندگان تجهیزات آسانسور

        </h1>



        <p>

            تولیدکنندگان معتبر قطعات و تجهیزات آسانسور را پیدا کنید

        </p>


    </section>





    <x-directory.filter-box
        register="ثبت تولیدکننده"
    />






    <div class="company-grid">



        @foreach($manufacturers as $manufacturer)



            <x-directory.manufacturer-card

                :manufacturer="$manufacturer"

            />



        @endforeach




    </div>





</main>




@include('sections.footer')



@endsection

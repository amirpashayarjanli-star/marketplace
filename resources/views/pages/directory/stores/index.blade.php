@extends('layouts.app')


@section('title','فروشگاه‌های قطعات آسانسور')


@section('content')


@include('sections.header-inner')



<main class="directory-page">


    <div class="container-app">

    <section class="directory-top">


        <h1>

            فروشگاه‌های قطعات آسانسور

        </h1>



        <p>

            فروشگاه‌های معتبر قطعات و تجهیزات آسانسور را پیدا کنید

        </p>


    </section>





    <x-directory.filter-box
        register="ثبت فروشگاه"
        search="جستجوی فروشگاه..."
    />







    <div class="company-grid">



        @foreach($stores as $store)



            <x-directory.store-card

                :store="$store"

            />



        @endforeach




    </div>

    </div>


</main>





@include('sections.footer')



@endsection

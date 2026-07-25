<?php

namespace App\Http\Controllers;


class TechnicianController extends Controller
{

    public function index()
    {


        $technicians = collect([


            [
                'name' => 'احمد رضایی',
                'avatar' => 'images/logo/logo.svg',
                'city' => 'قم',
                'rating' => '4.9',
                'comments' => 150,
                'jobs' => 230,
            ],



            [
                'name' => 'محمد کریمی',
                'avatar' => 'images/logo/logo.svg',
                'city' => 'تهران',
                'rating' => '4.8',
                'comments' => 90,
                'jobs' => 180,
            ],



            [
                'name' => 'علی احمدی',
                'avatar' => 'images/logo/logo.svg',
                'city' => 'اصفهان',
                'rating' => '4.7',
                'comments' => 75,
                'jobs' => 120,
            ],



        ]);




        return view(
            'pages.directory.technicians.index',
            compact('technicians')
        );


    }

}

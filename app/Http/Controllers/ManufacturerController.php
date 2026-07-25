<?php

namespace App\Http\Controllers;


class ManufacturerController extends Controller
{

    public function index()
    {

        $manufacturers = collect([


            [
                'name' => 'گروه صنعتی آسانسور آریا',
                'logo' => 'images/logo/logo.svg',
                'city' => 'تهران',
                'rating' => '4.9',
                'comments' => 150,
            ],


            [
                'name' => 'تولید آسانسور پارس',
                'logo' => 'images/logo/logo.svg',
                'city' => 'قم',
                'rating' => '4.7',
                'comments' => 90,
            ],


            [
                'name' => 'صنایع آسانبر ایران',
                'logo' => 'images/logo/logo.svg',
                'city' => 'اصفهان',
                'rating' => '4.8',
                'comments' => 110,
            ],


        ]);



        return view(
            'pages.directory.manufacturers.index',
            compact('manufacturers')
        );

    }

}

<?php

namespace App\Http\Controllers;


class StoreController extends Controller
{

    public function index()
    {

        $stores = collect([


            [
                'name' => 'فروشگاه آسانبر نوین',
                'logo' => 'images/logo/logo.svg',
                'city' => 'تهران',
                'rating' => '4.8',
                'comments' => 120,
            ],


            [
                'name' => 'قطعات آسانسور پارس',
                'logo' => 'images/logo/logo.svg',
                'city' => 'قم',
                'rating' => '4.6',
                'comments' => 80,
            ],


            [
                'name' => 'مرکز قطعات آسانسور ایران',
                'logo' => 'images/logo/logo.svg',
                'city' => 'اصفهان',
                'rating' => '4.9',
                'comments' => 200,
            ],


        ]);



        return view(
            'pages.directory.stores.index',
            compact('stores')
        );

    }

}

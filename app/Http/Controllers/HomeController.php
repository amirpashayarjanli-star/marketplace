<?php

namespace App\Http\Controllers;

use App\Services\NavasanService;

class HomeController extends Controller
{
    public function index(NavasanService $navasan)
    {

        return view('pages.home', [

            'topCompanies'      => collect(),

            'topManufacturers'  => collect(),

            'topStores'         => collect(),

            'latestProjects'    => collect(),

            'latestInquiries'   => collect(),

            'latestArticles'    => collect(),


            'dollar' => $navasan->getUsdPrice() ?? [
                'price' => 0,
                'change' => 0,
                'date' => 'اکنون'
            ],

        ]);

    }
}

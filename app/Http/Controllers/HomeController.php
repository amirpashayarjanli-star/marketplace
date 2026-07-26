<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Project;
use App\Services\NavasanService;


class HomeController extends Controller
{

    public function index(NavasanService $navasan)
    {

        return view('pages.home', [

            'topCompanies' => Company::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),


            'topManufacturers' => Manufacturer::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),


            'topStores' => Store::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),


            'latestProjects' => Project::where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),


            'latestInquiries' => collect(),


            'latestArticles' => collect(),


            'dollar' => $navasan->getUsdPrice() ?? [

                'price' => 0,
                'change' => 0,
                'date' => 'اکنون'

            ],


        ]);

    }

}

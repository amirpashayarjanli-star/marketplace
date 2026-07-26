<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Project;
use App\Models\Technician;

class HomeController extends Controller
{

    public function index()
    {

        $topCompanies = Company::where('is_active', 1)
            ->latest()
            ->limit(6)
            ->get();


        $topManufacturers = Manufacturer::where('is_active', 1)
            ->latest()
            ->limit(6)
            ->get();


        $topStores = Store::where('is_active', 1)
            ->latest()
            ->limit(6)
            ->get();


        $latestProjects = Project::where('is_active', 1)
            ->latest()
            ->limit(6)
            ->get();


        $topTechnicians = Technician::where('is_active', 1)
            ->latest()
            ->limit(6)
            ->get();


        $dollar = 0;



        return view('pages.home', [

            'topCompanies' => $topCompanies,

            'topManufacturers' => $topManufacturers,

            'topStores' => $topStores,

            'latestProjects' => $latestProjects,

            'topTechnicians' => $topTechnicians,

            'dollar' => $dollar,

        ]);

    }

}

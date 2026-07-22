<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [

            'topCompanies'      => collect(),

            'topManufacturers'  => collect(),

            'topStores'         => collect(),

            'latestProjects'    => collect(),

            'latestInquiries'   => collect(),

            'latestArticles'    => collect(),

        ]);
    }
}
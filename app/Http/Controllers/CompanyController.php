<?php

namespace App\Http\Controllers;

use App\Models\Company;


class CompanyController extends Controller
{

    public function index()
    {

        $companies = Company::where('is_active', true)
            ->latest()
            ->get();


        return view('pages.companies.index', [

            'companies' => $companies

        ]);

    }



    public function show($slug)
    {

        $company = Company::where('slug', $slug)

            ->where('is_active', true)

            ->with([

                'reviews' => function ($query) {

                    $query
                        ->where('is_verified', true)
                        ->latest();

                },

                'projects' => function ($query) {
                    $query->latest();
                },

                'services',

            ])

            ->firstOrFail();



        return view(
            'pages.profile.company.index',
            [

                'company' => $company

            ]
        );

    }

}

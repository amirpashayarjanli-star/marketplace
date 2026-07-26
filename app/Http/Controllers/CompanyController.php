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



        return view(
            'pages.companies.index',
            compact('companies')
        );

    }





    public function show($slug)
    {

        $company = Company::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();



        return view(
            'pages.profile.company.index',
            compact('company')
        );

    }

}

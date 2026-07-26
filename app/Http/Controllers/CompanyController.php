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
}

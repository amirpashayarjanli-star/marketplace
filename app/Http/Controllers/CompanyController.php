<?php

namespace App\Http\Controllers;


class CompanyController extends Controller
{

    public function index()
    {

        $companies = collect([

            [
                'name' => 'آسانسور اطلس',
                'logo' => 'images/demo/company.png',
                'city' => 'قم',
                'rating' => '4.8',
                'comments' => 120,
            ],


            [
                'name' => 'آسانسور پارس',
                'logo' => 'images/demo/company.png',
                'city' => 'تهران',
                'rating' => '4.6',
                'comments' => 85,
            ],


            [
                'name' => 'آسانسور ایرانیان',
                'logo' => 'images/demo/company.png',
                'city' => 'اصفهان',
                'rating' => '4.9',
                'comments' => 200,
            ],


        ]);



        return view('pages.companies.index', compact('companies'));

    }

}

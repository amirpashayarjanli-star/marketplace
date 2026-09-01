<?php

namespace App\Http\Controllers;

use App\Models\Company;


class CompanyController extends Controller
{

    public function index()
    {
        $query = Company::where('is_active', true);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        if (request('province')) {
            $query->where('province', request('province'));
        }

        if (request('sort') === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif (request('sort') === 'reviews') {
            $query->orderBy('reviews_count', 'desc');
        } else {
            $query->latest();
        }

        $companies = $query->paginate(15)->withQueryString();

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

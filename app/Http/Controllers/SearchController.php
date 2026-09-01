<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Technician;
use App\Models\Project;

class SearchController extends Controller
{

    public function index()
    {
        $q = trim((string) request('q'));

        $companies = collect();
        $manufacturers = collect();
        $stores = collect();
        $technicians = collect();
        $projects = collect();

        if ($q !== '') {

            $companies = Company::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%");
                })
                ->orderByDesc('rating')
                ->limit(8)
                ->get();

            $manufacturers = Manufacturer::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%");
                })
                ->orderByDesc('rating')
                ->limit(8)
                ->get();

            $stores = Store::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%");
                })
                ->orderByDesc('rating')
                ->limit(8)
                ->get();

            $technicians = Technician::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('skills', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%");
                })
                ->orderByDesc('rating')
                ->limit(8)
                ->get();

            $projects = Project::where('is_active', true)
                ->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('city', 'like', "%$q%");
                })
                ->latest()
                ->limit(8)
                ->get();
        }

        $totalResults = $companies->count()
            + $manufacturers->count()
            + $stores->count()
            + $technicians->count()
            + $projects->count();

        return view('pages.search.index', [
            'q' => $q,
            'companies' => $companies,
            'manufacturers' => $manufacturers,
            'stores' => $stores,
            'technicians' => $technicians,
            'projects' => $projects,
            'totalResults' => $totalResults,
        ]);
    }

}

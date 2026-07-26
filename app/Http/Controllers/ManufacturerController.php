<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;

class ManufacturerController extends Controller
{

    public function index()
    {
        $manufacturers = Manufacturer::where('is_active', true)
            ->latest()
            ->get();


        return view(
            'pages.directory.manufacturers.index',
            compact('manufacturers')
        );
    }





    public function show($slug)
    {

        $manufacturer = Manufacturer::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'products',
                'projects',
                'reviews'
            ])
            ->firstOrFail();



        return view(
            'pages.profile.manufacturer.index',
            compact('manufacturer')
        );

    }

}

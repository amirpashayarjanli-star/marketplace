<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;

class ManufacturerController extends Controller
{

    public function index()
    {
        $query = Manufacturer::where('is_active', true)
            ->with([
                'products',
                'projects',
                'reviews'
            ]);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        if (request('city')) {
            $query->where('city', request('city'));
        }

        if (request('sort') === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif (request('sort') === 'reviews') {
            $query->orderBy('reviews_count', 'desc');
        } else {
            $query->latest();
        }

        $manufacturers = $query->get();

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

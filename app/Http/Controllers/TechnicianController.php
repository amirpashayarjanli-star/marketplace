<?php

namespace App\Http\Controllers;

use App\Models\Technician;

class TechnicianController extends Controller
{

    public function index()
    {
        $query = Technician::where('is_active', true)
            ->with([
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

        $technicians = $query->paginate(15)->withQueryString();

        return view(
            'pages.directory.technicians.index',
            compact('technicians')
        );
    }





    public function show($slug)
    {

        $technician = Technician::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'projects',
                'reviews'
            ])
            ->firstOrFail();



        return view(
            'pages.profile.technician.index',
            compact('technician')
        );

    }

}

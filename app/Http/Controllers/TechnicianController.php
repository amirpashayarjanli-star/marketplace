<?php

namespace App\Http\Controllers;

use App\Models\Technician;

class TechnicianController extends Controller
{

    public function index()
    {

        $technicians = Technician::where('is_active', true)
            ->with([
                'projects',
                'reviews'
            ])
            ->latest()
            ->get();



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

<?php

namespace App\Http\Controllers;


use App\Models\Technician;


class TechnicianController extends Controller
{

    public function index()
    {

        $technicians = Technician::where('is_active', true)
            ->latest()
            ->get();



        return view(
            'pages.directory.technicians.index',
            compact('technicians')
        );

    }

}

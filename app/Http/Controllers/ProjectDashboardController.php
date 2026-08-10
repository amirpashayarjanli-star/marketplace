<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;



class ProjectDashboardController extends Controller
{


    public function index()
    {


        $user = Auth::user();



        $projects = match($user->type) {



            'employer' => Project::where(
                'employer_id',
                $user->employer?->id
            )
            ->latest()
            ->get(),




            'company' => Project::where(
                'company_id',
                $user->company?->id
            )
            ->latest()
            ->get(),




            'technician' => Project::where(
                'technician_id',
                $user->technician?->id
            )
            ->latest()
            ->get(),




            'manufacturer' => Project::where(
                'manufacturer_id',
                $user->manufacturer?->id
            )
            ->latest()
            ->get(),




            default => collect(),


        };





        return view(
            'dashboard.projects.index',
            compact('projects')
        );


    }









    public function create()
    {


        return view(
            'dashboard.projects.create'
        );


    }









    public function store(Request $request)
    {


        $request->validate([


            'title' => 'required',

            'province' => 'required',

            'city' => 'required',

            'type' => 'required',

            'description' => 'required',


        ]);





        $user = Auth::user();





        Project::create([


            'title' => $request->title,



            'slug' => str()->slug($request->title)
                .'-'
                .time(),




            'province' => $request->province,



            'city' => $request->city,



            'type' => $request->type,



            'description' => $request->description,



            'status' => 'open',




            'employer_id' => $user->employer?->id,




            'is_active' => true,



            'is_verified' => false,



        ]);







        return redirect()

            ->route('dashboard.projects')

            ->with(
                'success',
                'پروژه با موفقیت ثبت شد'
            );


    }









    public function show(Project $project)
    {


        $project->load([

            'employer',

            'company',

            'technician',

            'manufacturer',

            'inquiries'

        ]);




        return view(
            'dashboard.projects.show',
            compact('project')
        );


    }





}

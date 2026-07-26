<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{

    public function index()
    {

        $projects = Project::where('is_active', true)
            ->latest()
            ->get();



        return view(
            'pages.directory.projects.index',
            compact('projects')
        );

    }





    public function show($slug)
    {

        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'company',
                'manufacturer',
                'technician',
                'employer'
            ])
            ->firstOrFail();



        return view(
            'pages.profile.project.index',
            compact('project')
        );

    }

}

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

}

<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{

    public function index()
    {
        $query = Project::where('is_active', true);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        if (request('city')) {
            $query->where('city', request('city'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('sort') === 'newest') {
            $query->latest();
        }

        $projects = $query->latest()->get();

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

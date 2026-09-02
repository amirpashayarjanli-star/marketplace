<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{

    public function index()
    {
        /*
        | کارت پروژه نام شرکت مجری را نشان می‌دهد. بدون eager load، هر
        | کارت یک کوئری جدا می‌زد — صفحه‌ی ۱۵تایی ۱۵ کوئری اضافه داشت.
        */
        $query = Project::with('company')->where('is_active', true);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        if (request('province')) {
            $query->where('province', request('province'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('sort') === 'newest') {
            $query->latest();
        }

        $projects = $query->latest()->paginate(15)->withQueryString();

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

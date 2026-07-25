<?php

namespace App\Http\Controllers;


class ProjectController extends Controller
{

    public function index()
    {


        $projects = collect([


            [
                'name' => 'برج نگین',
                'image' => 'images/projects/project-1.webp',
                'city' => 'قم',
                'type' => 'مسکونی',
                'company' => 'آسانسور اطلس',
                'status' => 'تکمیل شده',
            ],



            [
                'name' => 'مجتمع آریا',
                'image' => 'images/projects/project-2.webp',
                'city' => 'تهران',
                'type' => 'تجاری',
                'company' => 'آسانسور پرو',
                'status' => 'در حال اجرا',
            ],



            [
                'name' => 'برج سپهر',
                'image' => 'images/projects/project-3.webp',
                'city' => 'اصفهان',
                'type' => 'اداری',
                'company' => 'گروه آسانبر ایران',
                'status' => 'تکمیل شده',
            ],



        ]);




        return view(
            'pages.directory.projects.index',
            compact('projects')
        );


    }

}

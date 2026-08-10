<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;
use App\Models\ProjectInquiry;



class ProjectInquiryController extends Controller
{


    public function store(Request $request, Project $project)
    {


        $request->validate([


            'message' => 'nullable|string|max:1000',


        ]);





        $user = Auth::user();





        // فقط شرکت، تکنسین و تولیدکننده بتوانند درخواست بدهند

        if(!in_array($user->type,[

            'company',

            'technician',

            'manufacturer'

        ])) {


            abort(403);


        }








        ProjectInquiry::create([


            'project_id' => $project->id,


            'user_id' => $user->id,


            'type' => $user->type,


            'message' => $request->message,



            'status' => 'pending',


        ]);







        return back()->with(

            'success',

            'درخواست همکاری شما ارسال شد'

        );


    }









    public function destroy(ProjectInquiry $inquiry)
    {


        $inquiry->delete();



        return back();


    }





}

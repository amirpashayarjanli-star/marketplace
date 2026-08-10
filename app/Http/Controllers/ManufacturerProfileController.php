<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ManufacturerProfileController extends Controller
{


    public function show()
    {

        $user = Auth::user();


        $manufacturer = $user->manufacturer;


        return view(
            'dashboard.manufacturer.profile',
            compact('manufacturer')
        );

    }





    public function update(Request $request)
    {


        $user = Auth::user();



        $request->validate([

            'name'=>'required',

            'description'=>'nullable',

            'city'=>'nullable',

            'experience'=>'nullable|integer',

        ]);




        $user->manufacturer()->updateOrCreate(

            [

                'user_id'=>$user->id

            ],


            [

                'name'=>$request->name,

                'description'=>$request->description,

                'city'=>$request->city,

                'experience'=>$request->experience,

            ]

        );



        return back()->with(
            'success',
            'اطلاعات پروفایل ذخیره شد'
        );


    }


}

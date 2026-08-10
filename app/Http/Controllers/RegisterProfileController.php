<?php

namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Technician;
use App\Models\Employer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class RegisterProfileController extends Controller
{


    public function show()
    {

        $user = Auth::user();


        if (!$user->type) {

            return redirect()
                ->route('register.type');

        }



        return match ($user->type) {


            'company' =>
                view('auth.profile.company'),


            'manufacturer' =>
                view('auth.profile.manufacturer'),


            'store' =>
                view('auth.profile.store'),


            'technician' =>
                view('auth.profile.technician'),


            'employer' =>
                view('auth.profile.employer'),


            default =>
                redirect()
                    ->route('register.type'),

        };


    }







    public function store(Request $request)
    {


        $user = Auth::user();



        switch ($user->type) {



            case 'company':


                $request->validate([

                    'company_name' => 'required',

                ]);



                Company::create([

                    'user_id' => $user->id,

                    'name' => $request->company_name,

                    'city' => $request->city,

                    'phone' => $request->phone,

                    'description' => $request->description,

                ]);


            break;







            case 'manufacturer':


                $request->validate([

                    'company_name' => 'required',

                ]);



                Manufacturer::create([

                    'user_id' => $user->id,

                    'name' => $request->company_name,

                    'city' => $request->city,

                    'phone' => $request->phone,

                    'description' => $request->description,

                ]);


            break;







            case 'store':


                $request->validate([

                    'store_name' => 'required',

                ]);



                Store::create([

                    'user_id' => $user->id,

                    'name' => $request->store_name,

                    'city' => $request->city,

                    'phone' => $request->phone,

                    'description' => $request->description,

                ]);


            break;







            case 'technician':


                $request->validate([

                    'skills' => 'required',

                ]);



                Technician::create([

                    'user_id' => $user->id,

                    'name' => $request->name,

                    'skills' => $request->skills,

                    'city' => $request->city,

                    'experience' => $request->experience,

                    'description' => $request->description,

                ]);


            break;







            case 'employer':


                $request->validate([

                    'city' => 'required',

                ]);



                Employer::create([

                    'user_id' => $user->id,

                    'name' => $request->name,

                    'city' => $request->city,

                    'phone' => $request->phone,

                ]);


            break;


        }






        $user->update([

            'status' => 'pending',

        ]);






        return redirect()
            ->route('pending');


    }


}

<?php

namespace App\Http\Controllers;


use App\Models\OtpCode;
use App\Models\User;
use App\Services\SmsService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class RegisterController extends Controller
{


    public function show()
    {
        return view('auth.register');
    }



    public function store(
        Request $request,
        SmsService $sms
    )
    {

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],


            'mobile' => [
                'required',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile'
            ],


            'password' => [
                'required',
                'confirmed',
                'min:6'
            ],

            'terms' => [
                'required',
                'accepted'
            ]

        ]);



        Session::put('register_data',[

            'name' => $request->name,

            'mobile' => $request->mobile,

            'password' => Hash::make(
                $request->password
            )

        ]);



        $code = random_int(10000,99999);



        OtpCode::create([

            'mobile' => $request->mobile,

            'code' => $code,

            'type' => 'register',

            'expires_at' => now()->addMinutes(5),

        ]);



        $sms->sendOtp(
            $request->mobile,
            $code
        );



        return redirect()
            ->route('register.otp');

    }





    public function type()
    {
        return view('auth.register-type');
    }





    public function saveType(Request $request)
    {


        $request->validate([

            'type' => [

                'required',

                'in:company,manufacturer,store,technician,employer'

            ]

        ]);



        $user = Auth::user();



        $user->update([

            'type' => $request->type

        ]);



        return redirect()
            ->route('register.profile');

    }



}

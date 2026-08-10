<?php

namespace App\Http\Controllers;


use App\Models\OtpCode;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class OtpController extends Controller
{


    public function showLoginOtp()
    {

        return view('auth.login-otp');

    }




    public function verifyLoginOtp(Request $request)
    {

        // قبلا ساختیم

    }





    public function showRegisterOtp()
    {

        if (!Session::has('register_data')) {

            return redirect()
                ->route('register');

        }


        return view('auth.register-otp');

    }




    public function verifyRegisterOtp(Request $request)
    {


        $request->validate([

            'code' => [

                'required',
                'digits:5'

            ]

        ]);



        $data = Session::get('register_data');



        $otp = OtpCode::where('mobile',$data['mobile'])

            ->where('type','register')

            ->where('code',$request->code)

            ->whereNull('verified_at')

            ->latest()

            ->first();



        if (!$otp) {


            return back()
                ->withErrors([

                    'code'=>'کد وارد شده صحیح نیست.'

                ]);

        }



        if ($otp->isExpired()) {


            return back()
                ->withErrors([

                    'code'=>'کد منقضی شده است.'

                ]);

        }




        $otp->update([

            'verified_at'=>now()

        ]);




        $user = User::create([


            'name'=>$data['name'],


            'mobile'=>$data['mobile'],


            'password'=>$data['password'],


            'status'=>'pending'


        ]);




        Auth::login($user);



        Session::forget('register_data');



        return redirect()
            ->route('register.type');


    }


}

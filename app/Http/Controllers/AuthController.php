<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;



class AuthController extends Controller
{


    public function showLogin()
    {

        return view('auth.login');

    }





    public function login(Request $request)
    {


        $request->validate([

            'mobile' => 'required',

            'password' => 'required',

        ]);





        if (!auth()->attempt([

            'mobile' => $request->mobile,

            'password' => $request->password,

        ])) {


            return back()->withErrors([

                'mobile' => 'اطلاعات ورود اشتباه است'

            ]);


        }






        $user = auth()->user();





        if($user->status !== 'approved') {


            return redirect()

                ->route('pending');


        }






        return redirect()

            ->route('dashboard');


    }



    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

}

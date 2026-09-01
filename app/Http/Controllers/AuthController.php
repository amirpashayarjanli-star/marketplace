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






        // جلوگیری از session fixation — شناسه‌ی نشست بعد از ورود عوض می‌شود.
        $request->session()->regenerate();


        $user = auth()->user();





        if($user->status === 'rejected') {


            auth()->logout();


            return back()->withErrors([

                'mobile' => 'حساب کاربری شما تایید نشد.'

            ]);


        }




        // ناقص یا در انتظار تایید → برو به مسیر تکمیل مخصوص نوع حسابش
        if($user->status !== 'approved') {


            return redirect()

                ->route($user->type === 'customer' ? 'service.setup' : 'profile.wizard');


        }



        if($user->type === 'customer') {


            return redirect()

                ->route('service.index');


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

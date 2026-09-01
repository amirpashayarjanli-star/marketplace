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

            'mobile' => [
                'required',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile'
            ],


            // فرم ثبت‌نام به کاربر «حداقل ۸ کاراکتر» را وعده می‌دهد و
            // نشانگر قدرت رمز هم بر همان مبنا امتیاز می‌دهد؛ قانون قبلی
            // min:6 بود و رمز ۶ کاراکتری را هم می‌پذیرفت.
            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],

            'terms' => [
                'required',
                'accepted'
            ]

        ]);



        // فقط شماره و رمز — بقیه‌ی اطلاعات (نام و ...) از داشبورد
        // در ویزارد تکمیل پروفایل پر می‌شود.
        Session::put('register_data',[

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





}

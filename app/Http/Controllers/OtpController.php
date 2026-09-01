<?php

namespace App\Http\Controllers;


use App\Models\OtpCode;
use App\Models\User;
use App\Services\SmsService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class OtpController extends Controller
{


    public function showLoginOtp()
    {

        return view('auth.login-otp', [

            'mobile' => Session::get('login_otp_mobile'),

        ]);

    }




    /*
    |--------------------------------------------------------------------------
    | ارسال کد ورود
    |--------------------------------------------------------------------------
    |
    | این متد قبلاً وجود نداشت. صفحه‌ی /login/otp فرم وارد کردن کد را نشان
    | می‌داد ولی هیچ‌جای برنامه کدی از نوع login ساخته و پیامک نمی‌شد، پس
    | ورود با کد یکبار مصرف عملاً بن‌بست بود.
    |
    */
    public function sendLoginOtp(Request $request, SmsService $sms)
    {

        $request->validate([
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ], [
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex'    => 'شماره موبایل صحیح نیست.',
        ]);


        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {

            return back()->withErrors([
                'mobile' => 'کاربری با این شماره ثبت نام نکرده است.'
            ]);

        }


        if ($user->status === 'rejected') {

            return back()->withErrors([
                'mobile' => 'حساب کاربری شما تایید نشد.'
            ]);

        }


        $code = random_int(10000, 99999);


        OtpCode::create([
            'mobile'     => $request->mobile,
            'code'       => $code,
            'type'       => 'login',
            'expires_at' => now()->addMinutes(5),
        ]);


        $sms->sendOtp($request->mobile, (string) $code);


        Session::put('login_otp_mobile', $request->mobile);


        return redirect()
            ->route('login.otp')
            ->with('success', 'کد ورود ارسال شد.');

    }




    public function verifyLoginOtp(Request $request)
    {
        // شماره از نشست خوانده می‌شود (همان شماره‌ای که کد برایش رفته).
        // فرم قبلاً یک input مخفی خالی می‌فرستاد و اعتبارسنجی همیشه رد می‌شد.
        $mobile = $request->input('mobile') ?: Session::get('login_otp_mobile');

        $request->merge(['mobile' => $mobile]);


        // قانون regex باید آرایه باشد نه رشته‌ی pipe-جدا: چون خودِ الگو هم
        // یک | دارد (\+98|0)، فرمت رشته‌ای آن را به عنوان یک قانون جدا و
        // نامعتبر می‌خواند و preg_match با «No ending delimiter» کرش می‌کرد —
        // یعنی ورود با کد یکبار مصرف همیشه با خطای 500 روبرو می‌شد.
        $request->validate([
            'mobile' => ['required', 'regex:/^(\+98|0)?9\d{9}$/'],
            'code' => 'required|digits:5',
        ], [
            'mobile.required' => 'ابتدا شماره موبایل خود را وارد کنید و کد بگیرید.',
            'mobile.regex' => 'شماره موبایل صحیح نیست.',
            'code.required' => 'کد تایید الزامی است.',
            'code.digits' => 'کد باید 5 رقم باشد.',
        ]);

        // Find OTP code
        $otp = OtpCode::where('mobile', $mobile)
            ->where('type', 'login')
            ->where('code', $request->code)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otp) {
            return back()->withErrors(['code' => 'کد وارد شده صحیح نیست.']);
        }

        if ($otp->isExpired()) {
            return back()->withErrors(['code' => 'کد منقضی شده است.']);
        }

        // Find or create user
        $user = User::where('mobile', $mobile)->first();

        if (!$user) {
            return back()->withErrors(['mobile' => 'کاربری با این شماره ثبت نام نکرده است.']);
        }

        if ($user->status === 'rejected') {
            return back()->withErrors(['mobile' => 'حساب کاربری شما تایید نشد.']);
        }

        // Mark OTP as verified
        $otp->update(['verified_at' => now()]);

        // Login user
        Auth::login($user, remember: true);

        // جلوگیری از session fixation
        $request->session()->regenerate();

        Session::forget('login_otp_mobile');

        // کاربری که پروفایلش کامل نیست باید اول برود سراغ تکمیل
        if ($user->status !== 'approved') {
            return redirect()->route($user->type === 'customer' ? 'service.setup' : 'profile.wizard');
        }

        if ($user->type === 'customer') {
            return redirect()->intended(route('service.index'));
        }

        return redirect()->intended(route('dashboard'));
    }





    public function showRegisterOtp()
    {

        if (!Session::has('register_data')) {

            return redirect()
                ->route('register');

        }


        return view('auth.register-otp');

    }




    /*
    |--------------------------------------------------------------------------
    | ارسال مجدد کد ثبت‌نام
    |--------------------------------------------------------------------------
    |
    | دکمه‌ی «ارسال مجدد کد» در register-otp.blade.php قبلاً فقط یک
    | تایمر جاوااسکریپتی بود و هیچ کد جدیدی تولید/ارسال نمی‌شد — یعنی
    | اگر کد اول منقضی می‌شد، کاربر برای همیشه گیر می‌کرد و باید از اول
    | ثبت‌نام می‌کرد. این متد کد تازه می‌سازد و دوباره پیامک می‌کند.
    |
    */
    public function resendRegisterOtp(SmsService $sms)
    {

        $data = Session::get('register_data');

        if (! is_array($data) || empty($data['mobile'])) {

            return redirect()
                ->route('register')
                ->withErrors([
                    'code' => 'زمان ثبت‌نام به پایان رسید. لطفاً دوباره تلاش کنید.'
                ]);

        }

        $code = random_int(10000, 99999);

        OtpCode::create([
            'mobile'     => $data['mobile'],
            'code'       => $code,
            'type'       => 'register',
            'expires_at' => now()->addMinutes(5),
        ]);

        $sms->sendOtp($data['mobile'], (string) $code);

        return redirect()
            ->route('register.otp')
            ->with('success', 'کد جدید ارسال شد.');

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



        // اگر نشست بین مرحله‌ی ثبت‌نام و وارد کردن کد منقضی شده باشد،
        // $data خالی است و دسترسی به $data['mobile'] خطای 500 می‌داد.
        if (! is_array($data) || empty($data['mobile'])) {

            return redirect()
                ->route('register')
                ->withErrors([
                    'code' => 'زمان ثبت‌نام به پایان رسید. لطفاً دوباره تلاش کنید.'
                ]);

        }



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




        // کاربر تازه هیچ پروفایلی ندارد، پس وضعیتش incomplete است.
        // نام هنوز خالی است — از داشبورد در ویزارد تکمیل پروفایل پر می‌شود.
        $user = User::create([


            'mobile'=>$data['mobile'],


            'password'=>$data['password'],


            'status'=>'incomplete'


        ]);




        Auth::login($user);

        // جلوگیری از session fixation
        $request->session()->regenerate();



        Session::forget('register_data');



        return redirect()
            ->route('profile.wizard.type');


    }


}

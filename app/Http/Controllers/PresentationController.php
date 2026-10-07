<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Vite;
use Throwable;

/*
|--------------------------------------------------------------------------
| ارائه‌ی کلاسی — OSI و TCP/IP
|--------------------------------------------------------------------------
|
| یک صفحه‌ی اسلاید تمام‌صفحه که پشت رمز است. باز شدن قفل فقط در نشست
| همان مرورگر ثبت می‌شود و به حساب کاربری ربطی ندارد، تا روی کامپیوتر
| مدرسه بدون ورود به سایت هم کار کند.
|
*/

class PresentationController extends Controller
{
    private const SESSION_KEY = 'presentation.unlocked';

    public function show(Request $request): Response
    {
        $view = $request->session()->get(self::SESSION_KEY)
            ? 'presentation.show'
            : 'presentation.unlock';

        return response()
            ->view($view, ['fontUrl' => $this->fontUrl()])
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'no-store, private');
    }

    public function unlock(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->input('password'), config('presentation.password_hash'))) {
            return back()->withErrors(['password' => 'رمز درست نیست.']);
        }

        $request->session()->regenerate();
        $request->session()->put(self::SESSION_KEY, true);

        return redirect()->route('presentation.show');
    }

    public function lock(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('presentation.show');
    }

    /**
     * فونت وزیرمتن سایت از build ویت می‌آید. اگر build یا manifest در دسترس
     * نباشد صفحه نباید بشکند؛ با فونت سیستم ادامه می‌دهد.
     */
    private function fontUrl(): ?string
    {
        try {
            return Vite::asset('resources/fonts/Vazirmatn.woff2');
        } catch (Throwable) {
            return null;
        }
    }
}

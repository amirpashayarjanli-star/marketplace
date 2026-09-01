<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| فقط کاربران تاییدشده
|--------------------------------------------------------------------------
|
| این middleware روی بخش‌های اصلی داشبورد (پروژه‌ها و ...) نشسته.
| ویزارد تکمیل پروفایل عمداً بیرون از این محافظ است، وگرنه کاربری که
| هنوز پروفایلش را کامل نکرده هرگز نمی‌توانست کاملش کند.
|
| قبلاً این middleware کاربر را logout می‌کرد که رفتار درستی نبود —
| کاربر بی‌آنکه بفهمد چرا، از حسابش بیرون می‌افتاد.
|
*/

class EnsureUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->status === 'approved') {
            return $next($request);
        }

        // مشتری مسیر جدایی از ویزارد کسب‌وکارها داره
        $incompleteRoute = $user->type === 'customer' ? 'service.setup' : 'profile.wizard';

        // هنوز نوع حساب یا پروفایلش کامل نیست → برو سراغ تکمیل
        if (in_array($user->status, ['incomplete', null], true)) {

            return redirect()
                ->route($incompleteRoute)
                ->with('error', 'برای دسترسی به این بخش، ابتدا پروفایل خود را کامل کنید.');
        }

        // کامل کرده و منتظر بررسی است
        if ($user->status === 'pending') {

            return redirect()
                ->route($incompleteRoute)
                ->with('error', 'پروفایل شما در انتظار تایید مدیر است.');
        }

        // رد شده
        return redirect()
            ->route($incompleteRoute)
            ->with('error', 'حساب شما تایید نشد. برای پیگیری با پشتیبانی تماس بگیرید.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| تکمیل پروفایل مشتری (پروسرویس)
|--------------------------------------------------------------------------
|
| برخلاف کسب‌وکارها (شرکت/تکنسین/...)، پروفایل مشتری هیچ‌وقت در سایت عمومی
| نمایش داده نمیشه، پس نیازی به ویزارد چندمرحله‌ای یا تایید ادمین نداره —
| یک فرم کوتاه، و بعدش مستقیم وارد پروسرویس میشه.
|
*/

class CustomerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->type !== 'customer') {
            abort(404);
        }

        // پروفایل کامله؟ برو داشبورد پروسرویس
        if ($user->customer) {
            return redirect()->route('service.index');
        }

        return view('service.setup', [
            'provinces' => config('provinces'),
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->type !== 'customer') {
            abort(404);
        }

        if ($user->customer) {
            return redirect()->route('service.index');
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|min:10|max:500',
        ], [], [
            'name' => 'نام',
            'phone' => 'شماره موبایل',
            'province' => 'استان',
            'city' => 'شهر',
            'address' => 'نشانی',
        ]);

        $customer = Customer::create([
            'user_id'  => $user->id,
            'name'     => $validated['name'],
            'mobile'   => $validated['phone'],
            'province' => $validated['province'],
            'city'     => $validated['city'],
            'address'  => $validated['address'],
        ]);

        // مشتری نیاز به تایید ادمین نداره — بلافاصله فعاله
        $user->update([
            'name'   => $customer->name,
            'status' => 'approved',
        ]);

        return redirect()
            ->route('service.index')
            ->with('success', 'خوش آمدید! حالا می‌توانید خرابی خود را ثبت کنید.');
    }
}

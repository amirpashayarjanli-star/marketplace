<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'approved') {
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->with('error', 'حساب کاربری شما هنوز تایید نشده یا رد شده است.');
            }
        }

        return $next($request);
    }
}

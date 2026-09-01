<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Services\ProfileWizard;

class AdminController extends Controller
{
    /**
     * فقط کاربرانی که پروفایلشان را کامل کرده‌اند و منتظر بررسی‌اند.
     * کاربران ناقص (incomplete) اینجا نمایش داده نمی‌شوند چون هنوز
     * چیزی برای بررسی وجود ندارد.
     */
    public function users()
    {
        $users = User::where('status', 'pending')
            ->with(['company', 'manufacturer', 'store', 'technician', 'employer'])
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
    }


    public function reviews()
    {
        $reviews = Review::where('is_verified', false)
            ->with('reviewable')
            ->latest()
            ->get();

        return view('admin.reviews', compact('reviews'));
    }


    /**
     * تایید کاربر — تنها جایی که پروفایل در سایت فعال می‌شود.
     */
    public function approve(User $user)
    {
        $profile = ProfileWizard::for($user)->profile();

        if (! $profile) {
            return back()->with('error', 'این کاربر هنوز پروفایلی نساخته است.');
        }

        if (! ProfileWizard::for($user)->isComplete()) {
            return back()->with('error', 'پروفایل این کاربر کامل نیست و قابل تایید نیست.');
        }

        $user->update(['status' => 'approved']);

        $profile->update([
            'is_active'   => true,
            'is_verified' => true,
        ]);

        return back()->with('success', 'کاربر تایید شد و پروفایلش در سایت نمایش داده می‌شود.');
    }


    /**
     * رد کاربر — پروفایل از سایت برداشته می‌شود.
     */
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        $profile = ProfileWizard::for($user)->profile();

        if ($profile) {
            $profile->update([
                'is_active'   => false,
                'is_verified' => false,
            ]);
        }

        return back()->with('success', 'کاربر رد شد و پروفایلش در سایت نمایش داده نمی‌شود.');
    }


    public function approveReview(Review $review)
    {
        $review->update(['is_verified' => true]);

        return back()->with('success', 'نظر تایید شد.');
    }


    public function rejectReview(Review $review)
    {
        $review->delete();

        return back()->with('success', 'نظر حذف شد.');
    }
}

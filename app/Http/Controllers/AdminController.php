<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::where('status','pending')
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


    public function approve(User $user)
    {


        $user->update([

            'status' => 'approved'

        ]);



        return back();

    }





    public function reject(User $user)
    {


        $user->update([

            'status' => 'rejected'

        ]);



        return back();

    }

    public function approveReview(Review $review)
    {
        $review->update([
            'is_verified' => true
        ]);

        return back()->with('success', 'نظر تایید شد.');
    }

    public function rejectReview(Review $review)
    {
        $review->delete();

        return back()->with('success', 'نظر حذف شد.');
    }

}

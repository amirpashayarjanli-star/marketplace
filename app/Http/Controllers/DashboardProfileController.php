<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return match($user->type) {
            'company' => view('dashboard.profile.company', ['profile' => $user->company]),
            'manufacturer' => view('dashboard.profile.manufacturer', ['profile' => $user->manufacturer]),
            'store' => view('dashboard.profile.store', ['profile' => $user->store]),
            'technician' => view('dashboard.profile.technician', ['profile' => $user->technician]),
            'employer' => view('dashboard.profile.employer', ['profile' => $user->employer]),
            default => abort(404),
        };
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $profile = match($user->type) {
            'company' => $user->company,
            'manufacturer' => $user->manufacturer,
            'store' => $user->store,
            'technician' => $user->technician,
            'employer' => $user->employer,
            default => null,
        };

        if (!$profile) {
            abort(404);
        }

        // Whitelist safe fields to prevent mass assignment
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url',
        ]);

        $profile->update(array_filter($validated));

        return back()->with('success', 'اطلاعات با موفقیت بروزرسانی شد');
    }
}

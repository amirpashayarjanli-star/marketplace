<?php

namespace App\Http\Controllers;


use App\Models\User;



class AdminController extends Controller
{


    public function users()
    {


        $users = User::where('status','pending')
            ->latest()
            ->get();



        return view('admin.users', compact('users'));

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


}

<?php

namespace App\Http\Controllers;

use App\Models\Store;

class StoreController extends Controller
{

    public function index()
    {
        $stores = Store::where('is_active', true)
            ->latest()
            ->get();


        return view(
            'pages.directory.stores.index',
            compact('stores')
        );
    }





    public function show($slug)
    {

        $store = Store::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'products',
                'reviews'
            ])
            ->firstOrFail();



        return view(
            'pages.profile.store.index',
            compact('store')
        );

    }

}

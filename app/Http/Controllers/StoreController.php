<?php

namespace App\Http\Controllers;

use App\Models\Store;

class StoreController extends Controller
{

    public function index()
    {
        $query = Store::where('is_active', true)
            ->with([
                'products',
                'reviews'
            ]);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        if (request('city')) {
            $query->where('city', request('city'));
        }

        if (request('sort') === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif (request('sort') === 'reviews') {
            $query->orderBy('reviews_count', 'desc');
        } else {
            $query->latest();
        }

        $stores = $query->paginate(15)->withQueryString();

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

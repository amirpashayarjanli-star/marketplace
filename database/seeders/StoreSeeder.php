<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;


class StoreSeeder extends Seeder
{

    public function run(): void
    {

        Store::create([

            'name' => 'فروشگاه قطعات آسانبر پارس',

            'slug' => 'pars-elevator-store',

            'city' => 'تهران',

            'province' => 'تهران',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'تامین کننده انواع قطعات و تجهیزات آسانسور',

            'experience' => 12,

            'products_count' => 1200,

            'brands_count' => 35,

            'rating' => 4.8,

            'reviews_count' => 95,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Store::create([

            'name' => 'فروشگاه آسانبر نوین',

            'slug' => 'novin-elevator-store',

            'city' => 'قم',

            'province' => 'قم',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'فروش و تامین قطعات آسانسور برای شرکت‌ها و تکنسین‌ها',

            'experience' => 8,

            'products_count' => 700,

            'brands_count' => 20,

            'rating' => 4.7,

            'reviews_count' => 60,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Store::create([

            'name' => 'بازرگانی آسانسور ایران',

            'slug' => 'iran-elevator-trade',

            'city' => 'اصفهان',

            'province' => 'اصفهان',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'عرضه قطعات و تجهیزات آسانسور',

            'experience' => 10,

            'products_count' => 950,

            'brands_count' => 28,

            'rating' => 4.9,

            'reviews_count' => 140,

            'is_verified' => true,

            'is_active' => true,

        ]);

    }

}

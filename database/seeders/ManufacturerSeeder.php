<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manufacturer;


class ManufacturerSeeder extends Seeder
{

    public function run(): void
    {

        Manufacturer::create([

            'name' => 'گروه صنعتی آسانسور آریا',

            'slug' => 'arya-elevator',

            'city' => 'تهران',

            'province' => 'تهران',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'تولیدکننده تجهیزات و قطعات آسانسور',

            'experience' => 15,

            'products_count' => 45,

            'customers_count' => 300,

            'rating' => 4.9,

            'reviews_count' => 150,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Manufacturer::create([

            'name' => 'تولید آسانسور پارس',

            'slug' => 'pars-manufacturer',

            'city' => 'قم',

            'province' => 'قم',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'تامین و تولید تجهیزات آسانسور',

            'experience' => 10,

            'products_count' => 30,

            'customers_count' => 180,

            'rating' => 4.7,

            'reviews_count' => 90,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Manufacturer::create([

            'name' => 'صنایع آسانبر ایران',

            'slug' => 'iran-elevator-industry',

            'city' => 'اصفهان',

            'province' => 'اصفهان',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'تولیدکننده انواع قطعات آسانسور',

            'experience' => 12,

            'products_count' => 60,

            'customers_count' => 250,

            'rating' => 4.8,

            'reviews_count' => 110,

            'is_verified' => true,

            'is_active' => true,

        ]);

    }

}

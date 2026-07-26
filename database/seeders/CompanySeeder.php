<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;


class CompanySeeder extends Seeder
{

    public function run(): void
    {

        Company::create([

            'name' => 'آسانسور اطلس',

            'slug' => 'atlas-elevator',

            'city' => 'قم',

            'province' => 'قم',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'شرکت آسانسوری فعال در زمینه نصب، سرویس و تعمیر آسانسور',

            'rating' => 4.8,

            'reviews_count' => 120,

            'experience' => 10,

            'projects_count' => 85,

            'is_verified' => true,

            'is_active' => true,

        ]);




        Company::create([

            'name' => 'آسانسور پارس',

            'slug' => 'pars-elevator',

            'city' => 'تهران',

            'province' => 'تهران',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'ارائه خدمات نصب و نگهداری آسانسور',

            'rating' => 4.6,

            'reviews_count' => 85,

            'experience' => 8,

            'projects_count' => 60,

            'is_verified' => true,

            'is_active' => true,

        ]);




        Company::create([

            'name' => 'آسانسور ایرانیان',

            'slug' => 'iranian-elevator',

            'city' => 'اصفهان',

            'province' => 'اصفهان',

            'logo' => 'images/logo/company-logo.png',

            'description' => 'تامین و اجرای پروژه‌های آسانسوری',

            'rating' => 4.9,

            'reviews_count' => 200,

            'experience' => 12,

            'projects_count' => 140,

            'is_verified' => true,

            'is_active' => true,

        ]);

    }

}

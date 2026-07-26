<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Technician;


class TechnicianSeeder extends Seeder
{

    public function run(): void
    {

        Technician::create([

            'name' => 'محمد رضایی',

            'slug' => 'mohammad-rezaei',

            'avatar' => 'images/logo/company-logo.png',

            'city' => 'تهران',

            'province' => 'تهران',

            'description' => 'تکنسین نصب، سرویس و تعمیر تخصصی آسانسور',

            'experience' => 8,

            'projects_count' => 180,

            'repairs_count' => 420,

            'rating' => 4.9,

            'reviews_count' => 75,

            'is_verified' => true,

            'is_active' => true,

        ]);






        Technician::create([

            'name' => 'علی احمدی',

            'slug' => 'ali-ahmadi',

            'avatar' => 'images/logo/company-logo.png',

            'city' => 'قم',

            'province' => 'قم',

            'description' => 'متخصص تعمیرات و عیب‌یابی آسانسور',

            'experience' => 6,

            'projects_count' => 120,

            'repairs_count' => 300,

            'rating' => 4.8,

            'reviews_count' => 50,

            'is_verified' => true,

            'is_active' => true,

        ]);






        Technician::create([

            'name' => 'رضا کریمی',

            'slug' => 'reza-karimi',

            'avatar' => 'images/logo/company-logo.png',

            'city' => 'اصفهان',

            'province' => 'اصفهان',

            'description' => 'نصب و راه‌اندازی سیستم‌های آسانسور',

            'experience' => 10,

            'projects_count' => 250,

            'repairs_count' => 500,

            'rating' => 4.9,

            'reviews_count' => 100,

            'is_verified' => true,

            'is_active' => true,

        ]);

    }

}

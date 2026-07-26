<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Company;
use App\Models\Technician;
use App\Models\Manufacturer;
use App\Models\Employer;


class ProjectSeeder extends Seeder
{

    public function run(): void
    {

        $company = Company::first();

        $technician = Technician::first();

        $manufacturer = Manufacturer::first();



        Project::create([

            'title' => 'برج نگین',

            'slug' => 'borj-negin',

            'image' => 'images/logo/company-logo.png',

            'city' => 'قم',

            'province' => 'قم',

            'type' => 'نصب و راه اندازی آسانسور',

            'description' => 'اجرای کامل سیستم آسانسور برج نگین',

            'company_id' => $company?->id,

            'technician_id' => $technician?->id,

            'manufacturer_id' => $manufacturer?->id,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Project::create([

            'title' => 'مجتمع آریا',

            'slug' => 'aria-complex',

            'image' => 'images/logo/company-logo.png',

            'city' => 'تهران',

            'province' => 'تهران',

            'type' => 'تعمیر و بازسازی آسانسور',

            'description' => 'بازسازی و ارتقای سیستم کنترل آسانسور',

            'company_id' => $company?->id,

            'technician_id' => $technician?->id,

            'manufacturer_id' => $manufacturer?->id,

            'is_verified' => true,

            'is_active' => true,

        ]);





        Project::create([

            'title' => 'برج سپهر',

            'slug' => 'sepehr-tower',

            'image' => 'images/logo/company-logo.png',

            'city' => 'اصفهان',

            'province' => 'اصفهان',

            'type' => 'سرویس و نگهداری',

            'description' => 'سرویس دوره‌ای و نگهداری آسانسور',

            'company_id' => $company?->id,

            'technician_id' => $technician?->id,

            'manufacturer_id' => $manufacturer?->id,

            'is_verified' => true,

            'is_active' => true,

        ]);

    }

}

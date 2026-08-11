<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Technician;
use App\Models\Employer;
use App\Models\Project;
use App\Models\Product;
use App\Models\Review;


class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::create([
            'name' => 'Admin User',
            'mobile' => '09000000000',
            'email' => null,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'approved',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Sample Company',
            'mobile' => '09111111111',
            'email' => 'company@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'status' => 'approved',
            'type' => 'company',
        ]);

        Company::create([
            'user_id' => 2,
            'name' => 'شرکت آسانسور پرو',
            'slug' => 'asansor-pro',
            'manager_name' => 'علی محمدی',
            'mobile' => '09111111111',
            'phone' => '02144445555',
            'email' => 'company@example.com',
            'website' => 'https://example.com',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'تهران، خیابان انقلاب',
            'description' => 'شرکت متخصص در تولید و نصب آسانسور',
            'is_active' => true,
            'is_verified' => true,
        ]);

        Company::create([
            'user_id' => 2,
            'name' => 'شرکت اورج',
            'slug' => 'oraj',
            'manager_name' => 'مریم کریمی',
            'mobile' => '09999999999',
            'phone' => '02133334444',
            'email' => 'oraj@example.com',
            'website' => 'https://oraj.com',
            'province' => 'تهران',
            'city' => 'تهران',
            'address' => 'تهران، خیابان فلسطین',
            'description' => 'متخصص در تکنسینی و تعمیر آسانسور',
            'is_active' => true,
            'is_verified' => true,
        ]);

        Review::create([
            'name' => 'احمد',
            'comment' => 'خدمات بسیار خوبی دریافت کردم. تیم حرفه‌ای و وقت‌شناس.',
            'rating' => 5,
            'reviewable_type' => Company::class,
            'reviewable_id' => 1,
            'is_verified' => true,
        ]);

        Review::create([
            'name' => 'فاطمه',
            'comment' => 'تجربه خوبی داشتم. هزینه‌ها منطقی و سرویس عالی.',
            'rating' => 4,
            'reviewable_type' => Company::class,
            'reviewable_id' => 2,
            'is_verified' => true,
        ]);

    }

}

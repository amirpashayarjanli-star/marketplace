<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Company;


class ReviewSeeder extends Seeder
{

    public function run(): void
    {

        $company = Company::first();



        if (!$company) {
            return;
        }



        Review::create([

            'name' => 'محمد کریمی',

            'comment' => 'اجرای پروژه بسیار خوب بود و پشتیبانی مناسبی داشتند.',

            'rating' => 5,

            'reviewable_type' => Company::class,

            'reviewable_id' => $company->id,

            'is_verified' => true,

        ]);





        Review::create([

            'name' => 'مدیریت ساختمان نگین',

            'comment' => 'تیم فنی منظم و پاسخگویی خوبی داشتند.',

            'rating' => 4,

            'reviewable_type' => Company::class,

            'reviewable_id' => $company->id,

            'is_verified' => true,

        ]);

    }

}

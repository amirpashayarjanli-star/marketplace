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

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);



        Company::factory(10)->create();

        Manufacturer::factory(10)->create();

        Store::factory(10)->create();

        Technician::factory(10)->create();

        Employer::factory(10)->create();



        Project::factory(30)->create();

        Product::factory(50)->create();

        Review::factory(50)->create();


    }

}

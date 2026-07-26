<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Store;
use App\Models\Technician;
use App\Models\Project;
use App\Models\Product;
use App\Models\Review;


class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);



        $this->call([

            CompanySeeder::class,
            ManufacturerSeeder::class,
            StoreSeeder::class,
            TechnicianSeeder::class,
            ProjectSeeder::class,
            ReviewSeeder::class,

        ]);

    }

}

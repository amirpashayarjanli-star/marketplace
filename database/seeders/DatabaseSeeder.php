<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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

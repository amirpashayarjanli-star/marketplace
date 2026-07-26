<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Employer;
use App\Models\Technician;
use App\Models\Manufacturer;


class ProjectFactory extends Factory
{

    public function definition(): array
    {

        return [

            'title' => fake()->sentence(3),

            'slug' => fake()->slug(),

            'image' => null,

            'province' => 'تهران',

            'city' => 'تهران',

            'type' => fake()->randomElement([
                'مسکونی',
                'تجاری',
                'اداری'
            ]),

            'description' => fake()->paragraph(),

            'employer_id' => Employer::inRandomOrder()->first()?->id,

            'company_id' => Company::inRandomOrder()->first()?->id,

            'technician_id' => Technician::inRandomOrder()->first()?->id,

            'manufacturer_id' => Manufacturer::inRandomOrder()->first()?->id,

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

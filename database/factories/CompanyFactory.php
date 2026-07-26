<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CompanyFactory extends Factory
{

    public function definition(): array
    {

        return [

            'name' => fake()->company(),

            'slug' => fake()->slug(),

            'manager_name' => fake()->name(),

            'mobile' => '09' . fake()->numerify('#########'),

            'phone' => fake()->phoneNumber(),

            'email' => fake()->safeEmail(),

            'website' => fake()->url(),

            'province' => 'تهران',

            'city' => 'تهران',

            'address' => fake()->address(),

            'logo' => null,

            'cover' => null,

            'description' => fake()->paragraph(),

            'rating' => fake()->randomFloat(1,3,5),

            'reviews_count' => fake()->numberBetween(0,100),

            'experience' => fake()->numberBetween(1,30),

            'projects_count' => fake()->numberBetween(0,200),

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

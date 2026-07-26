<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class TechnicianFactory extends Factory
{

    public function definition(): array
    {

        return [

            'name' => fake()->name(),

            'slug' => fake()->slug(),

            'avatar' => null,

            'mobile' => '09' . fake()->numerify('#########'),

            'phone' => fake()->phoneNumber(),

            'province' => 'تهران',

            'city' => 'تهران',

            'address' => fake()->address(),

            'description' => fake()->paragraph(),

            'experience' => fake()->numberBetween(1,30),

            'projects_count' => fake()->numberBetween(0,200),

            'repairs_count' => fake()->numberBetween(0,500),

            'rating' => fake()->randomFloat(1,3,5),

            'reviews_count' => fake()->numberBetween(0,100),

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

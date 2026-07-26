<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class StoreFactory extends Factory
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

            'experience' => fake()->numberBetween(1,30),

            'products_count' => fake()->numberBetween(0,500),

            'brands_count' => fake()->numberBetween(0,50),

            'rating' => fake()->randomFloat(1,3,5),

            'reviews_count' => fake()->numberBetween(0,100),

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

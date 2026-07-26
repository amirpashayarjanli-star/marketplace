<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class EmployerFactory extends Factory
{

    public function definition(): array
    {

        return [

            'name' => fake()->name(),

            'slug' => fake()->slug(),

            'mobile' => '09' . fake()->numerify('#########'),

            'phone' => fake()->phoneNumber(),

            'email' => fake()->safeEmail(),

            'province' => 'تهران',

            'city' => 'تهران',

            'address' => fake()->address(),

            'description' => fake()->paragraph(),

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

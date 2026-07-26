<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Store;
use App\Models\Technician;
use App\Models\Manufacturer;


class ReviewFactory extends Factory
{

    public function definition(): array
    {

        $items = [
            Company::class,
            Store::class,
            Technician::class,
            Manufacturer::class,
        ];


        $type = fake()->randomElement($items);


        return [

            'name' => fake()->name(),

            'comment' => fake()->paragraph(),

            'rating' => fake()->numberBetween(3,5),

            'reviewable_type' => $type,

            'reviewable_id' => $type::inRandomOrder()->first()?->id,

            'is_verified' => true,

        ];

    }

}

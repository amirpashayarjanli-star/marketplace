<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;
use App\Models\Manufacturer;


class ProductFactory extends Factory
{

    public function definition(): array
    {

        return [

            'name' => fake()->words(3, true),

            'slug' => fake()->slug(),

            'image' => null,

            'category' => fake()->randomElement([
                'موتور آسانسور',
                'تابلو فرمان',
                'درب آسانسور',
                'قطعات یدکی'
            ]),

            'description' => fake()->paragraph(),

            'brand_id' => null,

            'manufacturer_id' => Manufacturer::inRandomOrder()->first()?->id,

            'store_id' => Store::inRandomOrder()->first()?->id,

            'is_verified' => true,

            'is_active' => true,

        ];

    }

}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word,
            'brand_name' => $this->faker->word,
            'description' => $this->faker->text,
            'condition' => '新品',
            'price' => $this->faker->numberBetween(1000, 10000),
            'image_path' => null,
            'is_recommended' => false,
            'is_sold' => false,
        ];
    }
}
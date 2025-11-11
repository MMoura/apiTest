<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTypeFactory extends Factory
{
    public function modelName(): string
    {
        return \App\Models\ProductType::class;
    }

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}

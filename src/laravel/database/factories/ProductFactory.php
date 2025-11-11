<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductType;

class ProductFactory extends Factory
{
    public function modelName(): string
    {
        return \App\Models\Product::class;
    }

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'photo_path' => 'products/default.jpg',
            'product_type_id' => ProductType::factory(),
        ];
    }
}

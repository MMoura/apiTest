<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

class OrderFactory extends Factory
{
    public function modelName(): string
    {
        return \App\Models\Order::class;
    }

    public function definition()
    {
        return [
            'client_id' => Client::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    public function modelName(): string
    {
        return \App\Models\Client::class;
    }

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->streetAddress,
            'address2' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->citySuffix,
            'zip' => $this->faker->postcode,
            'registered_at' => now(),
        ];
    }
}

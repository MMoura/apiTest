<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Salty Pastel', 'Sweet Pastel', 'Combo', 'Beverage'];
        foreach ($types as $t) {
            ProductType::firstOrCreate(['name' => $t]);
        }
    }
}

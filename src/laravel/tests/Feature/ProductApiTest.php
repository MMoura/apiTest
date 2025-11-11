<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\ProductType;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_product_with_photo(): void
    {
        Storage::fake('public');

        $type = ProductType::factory()->create();

        $file = UploadedFile::fake()->image('pastel.jpg');

        $payload = [
            'name' => 'Pastel de Queijo',
            'price' => 6.50,
            'product_type_id' => $type->id,
            'photo' => $file,
        ];

        $response = $this->postJson('/api/v1/products', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Pastel de Queijo']);

        Storage::disk('public')->assertExists($response->json('photo_path'));
    }
}

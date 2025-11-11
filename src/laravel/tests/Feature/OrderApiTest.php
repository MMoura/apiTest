<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Product;
use App\Mail\OrderCreatedMail;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_and_dispatch_email(): void
    {
        Mail::fake();

        $client = Client::factory()->create();
        $product = Product::factory()->create(['price' => 5.00]);

        $payload = [
            'client_id' => $client->id,
            'products' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ],
        ];

        $response = $this->postJson('/api/v1/orders', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['client_id' => $client->id]);

        // Assert mail sent
        Mail::assertSent(OrderCreatedMail::class, function ($mail) use ($client) {
            return $mail->hasTo($client->email);
        });

        $this->assertDatabaseHas('orders', ['client_id' => $client->id]);
        $this->assertDatabaseHas('order_product', ['product_id' => $product->id, 'quantity' => 2]);
    }
}

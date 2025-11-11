<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

class ClientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_client(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '111-2222',
        ];

        $response = $this->postJson('/api/v1/clients', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'john@example.com']);

        $this->assertDatabaseHas('clients', ['email' => 'john@example.com']);
    }
}

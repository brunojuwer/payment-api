<?php

namespace Tests\Feature\Api\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_should_return_201(): void
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson('/api/tokens', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'accessToken',
                'token_type',
            ]);

    }
}

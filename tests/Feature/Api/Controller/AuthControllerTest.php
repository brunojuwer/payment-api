<?php

namespace Tests\Feature\Api\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_should_successfuly_login_on_valid_credentials(): void
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

    public function test_should_unsuccessfuly_login_on_invalid_credentials(): void
    {
        $data = [
            'email' => "wrong.email@email",
            'password' => 'wrongPassword'
        ];

        $response = $this->postJson('/api/tokens', $data);

        $response->assertStatus(401)
            ->assertJson([
                "status" => 401,
                "message" => "Unauthorized",
                "detail" => "Bad credentials"
            ]);
    }


    public function test_should_successfuly_logout_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->delete('api/tokens');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }

    public function test_should_unsuccessfuly_logout_for_unauthenticated_user(): void
    {
        $response = $this->deleteJson('api/tokens');
        $response->assertStatus(401);
    }
}

<?php

namespace Tests\Feature\Api\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_successfuly_create_a_new_user(): void
    {
        $request = [
            "full_name" => "Mikasa Jaeger",
            "email" => "mikasa@email.com",
            "password" => "1234@qwe",
            "cpf" => "226.953.341-64",
            "nationality" => "Eldian",
            "contact_number" => "(51)123224222",
            "birth_date" => "31/11/1997",
            "account_type" => "PF"
        ];

        $response = $this->postJson('api/users', $request);

        $response->assertStatus(201);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 9)
                 ->whereAllType(['data' => 'array'])
                 ->whereType('data.identify', 'integer')
                 ->whereType('data.name', 'string')
                 ->whereType('data.cpf', 'string')
                 ->whereType('data.email', 'string')
                 ->whereType('data.nationality', 'string')
                 ->whereType('data.contact', 'string')
                 ->whereType('data.birth', 'string')
                 ->whereType('data.created', 'string')
                 ->whereType('data.account', 'array')
        );
    }

    public function test_should_unsuccessfuly_create_a_new_user_with_duplicated_email(): void
    {

        $user = User::factory()->create();

        $request = [
            "full_name" => "Mikasa Jaeger",
            "email" => $user->email,
            "password" => "1234@qwe",
            "cpf" => "226.953.341-64",
            "nationality" => "Eldian",
            "contact_number" => "(51)123224222",
            "birth_date" => "31/11/1997",
            "account_type" => "PF"
        ];
        
        $response = $this->postJson('api/users', $request);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The email has already been taken.',
                'errors' => [
                    'email' => [
                        'The email has already been taken.'
                    ]
                ]
            ]);
    }

    public function test_should_unsuccessfuly_create_a_new_user_with_duplicated_cpf(): void
    {

        $user = User::factory()->create();

        $request = [
            "full_name" => "Mikasa Jaeger",
            "email" => 'mikasaa@email.com.br',
            "password" => "1234@qwe",
            "cpf" => $user->cpf,
            "nationality" => "Eldian",
            "contact_number" => "(51)123224222",
            "birth_date" => "31/11/1997",
            "account_type" => "PF"
        ];
        
        $response = $this->postJson('api/users', $request);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The cpf has already been taken.',
                'errors' => [
                    'cpf' => [
                        'The cpf has already been taken.'
                    ]
                ]
            ]);
    }
}

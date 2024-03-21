<?php

namespace Tests\Unit\Api\Controller;

use App\Http\Controllers\AuthController;
use App\Services\AuthService;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
 
    public function should_return_201_when_login(): void
    {
        // $userData = [
        //     'email' => 'user@example.com',
        //     'password' => 'secret',
        // ];
        $request = $this->createMock(Request::class);
        

        $authServiceMock = $this->createMock(AuthService::class);
        
        $authServiceMock->expects($this->once())
            ->method('createToken')
            ->with($request)
            ->willReturn('token');

        $controller = new AuthController($authServiceMock);

        $response = $controller->login($request);
        dd($response);

        $this->assertEquals(201, $response->status());
    }
}

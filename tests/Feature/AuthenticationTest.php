<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_token()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data['access_token']);
        $this->assertEquals('bearer', $data['token_type']);
        $this->assertNotEmpty($data['expires_in']);

        $response->assertHeader('Authorization', $data['access_token']);
    }

}
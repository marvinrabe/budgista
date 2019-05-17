<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_user()
    {
        $user = factory(User::class)->create();

        $this->signIn($user)
            ->query('me')
            ->setSelectionSet(['email', 'language', 'locale', 'currency', 'isVerified'])
            ->getData()
            ->assertJsonFragment([
                'me' => [
                    'email' => $user->email,
                    'language' => $user->language,
                    'locale' => $user->locale,
                    'currency' => $user->currency,
                    'isVerified' => $user->hasVerifiedEmail()
                ]
            ]);
    }

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

        $response->assertHeader('Authorization', $data['access_token']);
    }

}

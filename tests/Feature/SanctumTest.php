<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanctumTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
            'name' => 'unit test'
        ]);

        $this
            ->post('api/sanctum/login', [
                'email' => $user->email,
                'password' => 'password',
                'device_name' => 'unit test'
            ])
            ->assertSuccessful()
            ->assertJsonFragment([
                'name' => $user->name,
                'email' => $user->email,
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
            'name' => 'unit test'
        ]);
    }

    public function testToken()
    {
        $user = factory(User::class)->create();

        $result = $this
            ->post('api/sanctum/login', [
                'email' => $user->email,
                'password' => 'password',
                'device_name' => 'unit test'
            ])
            ->decodeResponseJson();

        $this
            ->get('api/me', ['Authorization' => 'Bearer '.$result['token']])
            ->assertJsonFragment([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
}

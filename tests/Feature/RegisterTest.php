<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_user() {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ]);
    }

    /** @test */
    public function check_if_user_has_onboarding_content() {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect(route('app'));

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertGreaterThan(0, $user->categories()->count());

        $this->assertGreaterThan(0, $user->accounts()->count());


    }

}
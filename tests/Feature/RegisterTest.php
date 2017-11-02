<?php

namespace Tests\Feature;

use App\Http\Middleware\DetectLocale;
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
    public function user_has_sample_content()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect(route('app'));

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Rent', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Cash', $user->accounts()->first()->name);
    }

    /** @test */
    public function user_is_localized()
    {
        app()->setLocale('de');

        $this->withoutMiddleware(DetectLocale::class);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertRedirect(route('app'));

        $user = User::where('email', 'john.doe@example.com')->first();

        $this->assertEquals('de', $user->language);

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Miete', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Bargeld', $user->accounts()->first()->name);
    }

}
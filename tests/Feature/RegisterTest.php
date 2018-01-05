<?php

namespace Tests\Feature;

use App\Http\Middleware\LoadUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function registerUser()
    {
        $this
            ->post('/register', [
                'email' => 'john.doe@example.com',
                'password' => 'secret',
            ])
            ->assertRedirect(route('app'));

        return User::where('email', 'john.doe@example.com')->first();
    }

    /** @test */
    public function user_is_stored_in_database()
    {
        $this->registerUser();

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com'
        ]);
    }

    /** @test */
    public function user_has_sample_content()
    {
        $user = $this->registerUser();

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Rent', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Cash', $user->accounts()->first()->name);
    }

    /** @test */
    public function user_has_localized_sample_content()
    {
        app()->setLocale('de');

        $this->withoutMiddleware(LoadUserLocale::class);

        $user = $this->registerUser();

        $this->assertEquals('de', $user->language);

        $this->assertGreaterThan(0, $user->categories()->count());
        $this->assertEquals('Miete', $user->categories()->first()->name);

        $this->assertGreaterThan(0, $user->accounts()->count());
        $this->assertEquals('Bargeld', $user->accounts()->first()->name);
    }

}
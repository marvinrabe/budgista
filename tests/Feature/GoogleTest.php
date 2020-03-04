<?php


namespace Tests\Feature;


use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as GoogleUser;
use Tests\TestCase;

class GoogleTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function testGoogleRoute()
    {
        Socialite::shouldReceive('driver')->with('google')->once();

        $this->get('/login/google')->isRedirection();
    }

    public function testRegistration()
    {
        Event::fake();

        $email = $this->faker->email;
        $id = $this->faker->randomNumber();
        $this->mockSocialiteFacade($email, $id);

        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);

        $this
            ->get('/login/google/callback')
            ->assertRedirect('/setup');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'google_id' => $id,
            'password' => null
        ]);
        Event::assertDispatched(Registered::class);
    }

    public function testDoesNotRequireVerification()
    {
        Mail::fake();

        $email = $this->faker->email;
        $id = $this->faker->randomNumber();
        $this->mockSocialiteFacade($email, $id);

        $this->assertDatabaseMissing('users', [
            'email' => $email
        ]);

        $this
            ->get('/login/google/callback')
            ->assertRedirect('/setup');

        $user = User::firstWhere('google_id', $id);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->email_verified_at);

        Mail::assertNothingSent();
    }

    public function testCanNotRegisterWhenUserExists()
    {
        $id = $this->faker->randomNumber();

        $user = factory(User::class)->create([
            'google_id' => null
        ]);

        $this->mockSocialiteFacade($user->email, $id);

        $this
            ->get('/login/google/callback')
            ->assertSessionHasErrors('google')
            ->assertRedirect('/login');

        $this->assertGuest();
    }

    public function testLogin()
    {
        $id = $this->faker->randomNumber();

        $user = factory(User::class)->create([
            'google_id' => $id
        ]);

        $this->mockSocialiteFacade($user->email, $id);

        $this
            ->get('/login/google/callback')
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function testLinkAccount()
    {
        $id = $this->faker->randomNumber();

        $user = factory(User::class)->create([
            'google_id' => null
        ]);

        $this->mockSocialiteFacade($user->email, $id);

        $this
            ->signIn($user)
            ->get('/login/google/callback')
            ->assertRedirect('/profile');

        $this->assertEquals($id, $user->fresh()->google_id);
    }

    public function testCanNotLinkExistingAccount()
    {
        $id = $this->faker->randomNumber();

        $user = factory(User::class)->create([
            'google_id' => $id
        ]);

        $this->mockSocialiteFacade($user->email, $id);

        $this
            ->signIn()
            ->get('/login/google/callback')
            ->assertSessionHasErrors('google')
            ->assertRedirect('/profile');
    }

    public function testUnlinkAccount()
    {
        $user = factory(User::class)->create([
            'google_id' => $this->faker->randomNumber()
        ]);

        $this
            ->signIn($user)
            ->from('/profile')
            ->delete('/profile/google')
            ->assertRedirect('/profile');

        $this->assertNull($user->fresh()->google_id);
    }

    public function testUserWithoutPasswordCanNotUnlinkAccount()
    {
        $user = factory(User::class)->create([
            'password' => null,
            'google_id' => $this->faker->randomNumber()
        ]);

        $this
            ->signIn($user)
            ->from('/profile')
            ->delete('/profile/google')
            ->assertSessionHasErrors('google');

        $this->assertNotNull($user->fresh()->google_id);
    }

    public function mockSocialiteFacade($email = 'foo@bar.com', $id = 1, $token = 'foo')
    {
        $socialiteUser = $this->createMock(GoogleUser::class);
        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;

        $provider = $this->createMock(GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }
}

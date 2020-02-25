<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdateEmailAddress()
    {
        Notification::fake();

        $this
            ->signIn()
            ->from('/profile')
            ->post('/profile/email', [
                'password' => 'password',
                'email' => 'something_new@example.com'
            ])
            ->assertRedirect('/profile');

        $this->assertEquals('something_new@example.com', Auth()->user()->email);
    }

    public function testEmailVerification()
    {
        Notification::fake();

        $this
            ->signIn()
            ->from('/profile')
            ->post('/profile/email', [
                'password' => 'password',
                'email' => 'something_new@example.com'
            ])
            ->assertRedirect('/profile');

        $this->assertEquals('something_new@example.com', Auth()->user()->email);

        Notification::assertSentTo(Auth()->user(), VerifyEmail::class);
    }

    public function testRequiresValidPassword()
    {
        $this
            ->signIn()
            ->post('/profile/email', [
                'password' => 'NOTAPASSWORD',
                'email' => 'something_new@example.com'
            ])
            ->assertSessionHasErrors('password');
    }

    public function testUniqueEmailAddress()
    {
        $otherUser = factory(User::class)->create();

        $this
            ->signIn()
            ->post('/profile/email', [
                'password' => 'secret',
                'email' => $otherUser->email
            ])
            ->assertSessionHasErrors('email');
    }

    public function testAllowsNoChange()
    {
        Notification::fake();

        $this
            ->signIn()
            ->post('/profile/email', [
                'password' => 'password',
                'email' => Auth()->user()->email
            ])
            ->assertRedirect();
    }

}

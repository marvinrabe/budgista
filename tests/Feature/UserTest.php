<?php

namespace Tests\Feature;

use App\Mails\UserDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteUser()
    {
        $this->signIn();

        $user = Auth()->user();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);

        $this->post('/profile/terminate', [
            'password' => 'password'
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function testRequiresPassword()
    {
        $this->signIn();

        $user = Auth()->user();

        $this
            ->post('/profile/terminate', [
                'password' => 'thisisthewrongpassword'
            ])
            ->assertSessionHasErrors('password');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function testLogsDeletions()
    {
        $this->signIn();

        $user = Auth()->user();

        $this
            ->post('/profile/terminate', [
                'feedback' => 'my feedback',
                'password' => 'password'
            ]);

        $this->assertDatabaseHas('deleted_users', [
            'created_at' => $user->created_at,
            'feedback' => 'my feedback',
        ]);
    }

    public function testEmailUserFeedback()
    {
        Mail::fake();

        $this->signIn();

        $user = Auth()->user();

        $this
            ->post('/profile/terminate', [
                'feedback' => 'my feedback',
                'password' => 'password'
            ]);

        $this->assertDatabaseHas('deleted_users', [
            'created_at' => $user->created_at,
            'feedback' => 'my feedback',
        ]);

        Mail::assertSent(UserDeleted::class);
    }

    public function testNoEmailWithoutFeedback()
    {
        Mail::fake();

        $this->signIn();

        $this
            ->post('/profile/terminate', [
                'feedback' => '',
                'password' => 'password'
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => Auth::id(),
        ]);

        Mail::assertNothingSent();
    }

}

<?php

namespace Tests\Feature;

use App\Mail\UserDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deletes_user()
    {
        $this->signIn();

        $user = Auth()->user();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);

        $this->delete('/api/user', [
            'password' => 'secret'
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_requires_password_for_account_deletion()
    {
        $this->signIn();

        $user = Auth()->user();

        $this
            ->delete('/api/user', [
                'password' => 'thisisthewrongpassword'
            ])
            ->assertSessionHasErrors('password');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_logs_deleted_accounts()
    {
        $this->signIn();

        $user = Auth()->user();

        $this
            ->delete('/api/user', [
                'feedback' => 'my feedback',
                'password' => 'secret'
            ]);

        $this->assertDatabaseHas('deleted_users', [
            'created_at' => $user->created_at,
            'feedback' => 'my feedback',
        ]);
    }

    /** @test */
    public function it_sends_an_email_with_user_feedback()
    {
        Mail::fake();

        $this->signIn();

        $user = Auth()->user();

        $this
            ->delete('/api/user', [
                'feedback' => 'my feedback',
                'password' => 'secret'
            ]);

        $this->assertDatabaseHas('deleted_users', [
            'created_at' => $user->created_at,
            'feedback' => 'my feedback',
        ]);

        Mail::assertSent(UserDeleted::class);
    }

    /** @test */
    public function it_does_not_send_an_email_when_feedback_is_empty()
    {
        Mail::fake();

        $this->signIn();

        $this
            ->delete('/api/user', [
                'feedback' => '',
                'password' => 'secret'
            ]);

        Mail::assertNothingSent();
    }

}

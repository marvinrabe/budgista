<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_update_the_email_address()
    {
        $this
            ->signIn()
            ->post('/api/user/email', [
                'password' => 'secret',
                'email' => 'something_new@example.com'
            ])
            ->assertSuccessful();

        $this->assertEquals('something_new@example.com', Auth()->user()->email);
    }

    /** @test */
    public function it_requires_the_valid_password_when_updating_the_email_address()
    {
        $this
            ->signIn()
            ->post('/api/user/email', [
                'password' => 'NOTAPASSWORD',
                'email' => 'something_new@example.com'
            ])
            ->assertStatus(403);
    }

    /** @test */
    public function it_should_fail_when_email_is_taken()
    {
        $otherUser = factory(User::class)->create();

        $this
            ->signIn()
            ->post('/api/user/email', [
                'password' => 'secret',
                'email' => $otherUser->email
            ])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_should_allow_no_changes_to_email()
    {
        $this
            ->signIn()
            ->post('/api/user/email', [
                'password' => 'secret',
                'email' => Auth()->user()->email
            ])
            ->assertSuccessful();
    }

}
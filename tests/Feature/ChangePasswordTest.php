<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_update_the_password()
    {
        $this
            ->signIn()
            ->post('/api/user/password', [
                'password' => 'secret',
                'new_password' => 'newpassword123'
            ])
            ->assertSuccessful();

        $this->assertTrue(Hash::check('newpassword123', Auth()->user()->password));
    }

    /** @test */
    public function it_requires_the_old_password_when_updating_the_password()
    {
        $this
            ->signIn()
            ->post('/api/user/password', [
                'password' => 'wrongpassword',
                'new_password' => 'newpassword123'
            ])
            ->assertStatus(403);
    }

    /** @test */
    public function it_should_have_atleast_6_characters()
    {
        $this
            ->signIn()
            ->post('/api/user/password', [
                'password' => 'wrongpassword',
                'new_password' => 'short'
            ])
            ->assertSessionHasErrors('new_password');
    }

}
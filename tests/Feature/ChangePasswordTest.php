<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdatePassword()
    {
        $user = factory(User::class)->create();

        $this
            ->signIn($user)
            ->from('/profile')
            ->post('/profile/password', [
                'password' => 'password',
                'new_password' => 'newpassword123'
            ])
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function testRequiresOldPassword()
    {
        $this
            ->signIn()
            ->post('/profile/password', [
                'password' => 'wrongpassword',
                'new_password' => 'newpassword123'
            ])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    public function testRequires8Characters()
    {
        $this
            ->signIn()
            ->post('/profile/password', [
                'password' => 'password',
                'new_password' => 'secret1'
            ])
            ->assertSessionHasErrors('new_password');
    }

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_not_be_accessed_by_normal_users()
    {
        $this->signIn()->get('/admin')->assertStatus(404);
    }

    /** @test */
    public function it_can_be_accessed_by_admins()
    {
        $this->signIn();

        $user = Auth()->user();
        $user->is_admin = true;
        $user->save();

        $this->get('/admin')->assertSuccessful();
    }

    /** @test */
    public function it_displays_user()
    {
        $this->signIn();

        $user = Auth()->user();
        $user->is_admin = true;
        $user->save();

        $this->get('/admin')
            ->assertSee(Auth()->user()->email);
    }

    /** @test */
    public function it_has_a_command_to_promote_users()
    {
        $user = factory(User::class)->create();

        Artisan::call('app:promote', [
            'email' => $user->email
        ]);

        $this->assertTrue($user->fresh()->is_admin);
    }

}
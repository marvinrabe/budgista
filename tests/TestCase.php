<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        // Authenticate with Web
        $this->actingAs($user);

        // Authenticate with API
        Passport::actingAs($user);

        return $this;
    }
}

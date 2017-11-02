<?php

namespace Tests;

use App\Models\User;
use App\Services\CreateSamples;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn()
    {
        $user = factory(User::class)->create();

        // Create some sample data
        CreateSamples::for ($user);

        // Authenticate with Web
        $this->actingAs($user);

        // Authenticate with API
        Passport::actingAs($user);

        return $user;
    }
}

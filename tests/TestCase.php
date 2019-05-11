<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestGraphQL;

    public function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        // Authenticate with Web
        $this->actingAs($user);

        return $this;
    }
}

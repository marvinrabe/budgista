<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('assertInertiaViewIs', function ($key) {
            Assert::assertEquals(
                $this->original->getData()['page']['component'],
                $key
            );
            return $this;
        });

        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);
            if ($key) {
                return Arr::get($props, $key);
            }
            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));
            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);
            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }
            return $this;
        });
    }

    public function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        // Authenticate with Web
        $this->actingAs($user);

        return $this;
    }
}

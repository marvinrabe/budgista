<?php

namespace Tests\Unit;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testIsNewbie() {
        $user = new User();
        $user->created_at = Carbon::now();

        $this->assertTrue($user->is_newbie);
    }

    public function testIsNotNewbie() {
        $user = new User();
        $user->created_at = Carbon::now()->subDays(7);

        $this->assertFalse($user->is_newbie);
    }
}

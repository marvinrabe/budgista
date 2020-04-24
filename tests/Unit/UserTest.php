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

    public function premium() {
        return [
            ['trial', null, false],
            ['trial', Carbon::tomorrow(), false],
            ['active', Carbon::tomorrow(), true],
            ['cancelled', Carbon::tomorrow(), true],
            ['active', Carbon::today(), true],
            ['cancelled', Carbon::today(), true],
            ['active', Carbon::yesterday(), false],
            ['cancelled', Carbon::yesterday(), false],
        ];
    }

    /**
     * @dataProvider premium
     */
    public function testPremiumStatus($state, $ends, $result) {
        $user = new User();

        $user->subscription_state = $state;
        $user->subscription_ends_at = $ends;

        $this->assertEquals($result, $user->premium);
    }
}

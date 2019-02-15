<?php

namespace Tests\Unit\Traits;

use App\Models\Account;
use App\Models\User;
use Tests\TestCase;

class BelongsToUserTraitTest extends TestCase
{

    /** @test */
    public function it_should_return_true_when_owned_by_user()
    {
        $user = new User();
        $user->id = 123;

        $account = new Account();
        $account->user_id = 123;

        $this->assertTrue($account->ownedBy($user));
    }

    /** @test */
    public function it_should_return_false_when_owned_by_another_user()
    {
        $user = new User();
        $user->id = 999;

        $account = new Account();
        $account->user_id = 123;

        $this->assertFalse($account->ownedBy($user));
    }

}

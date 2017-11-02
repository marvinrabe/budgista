<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{

    use HandlesAuthorization, UserPolicyTrait;

}

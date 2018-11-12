<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{

    use HandlesAuthorization, UserPolicyTrait;

}

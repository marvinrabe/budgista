<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{

    use HandlesAuthorization, UserPolicyTrait;

}

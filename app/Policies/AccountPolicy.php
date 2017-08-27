<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Account.
     *
     * @param  \App\Models\User $user
     * @param Account $account
     * @return mixed
     */
    public function view(User $user, Account $account)
    {
        return $user->can('view', $account->budget);
    }

    /**
     * Determine whether the user can create Accounts.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create', Budget::class);
    }

    /**
     * Determine whether the user can update the Account.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Account $Account
     * @return mixed
     */
    public function update(User $user, Account $account)
    {
        return $user->can('update', $account->budget);
    }

    /**
     * Determine whether the user can delete the Account.
     *
     * @param  \App\Models\User $user
     * @param Account $account
     * @return mixed
     */
    public function delete(User $user, Account $account)
    {
        return $user->can('delete', $account->budget);
    }

}

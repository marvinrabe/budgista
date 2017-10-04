<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Transaction.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Transaction $Transaction
     * @return boolean
     */
    public function view(User $user, Transaction $transaction)
    {
        return $user->can('view', $transaction->account);
    }

    /**
     * Determine whether the user can create Transactions.
     *
     * @param  \App\Models\User $user
     * @return boolean
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Transaction.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Transaction $Transaction
     * @return boolean
     */
    public function update(User $user, Transaction $transaction)
    {
        return $user->can('update', $transaction->account);
    }

    /**
     * Determine whether the user can delete the Transaction.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Transaction $Transaction
     * @return boolean
     */
    public function delete(User $user, Transaction $transaction)
    {
        return $user->can('update', $transaction->account);
    }
}

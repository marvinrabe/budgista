<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Budget;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Budget.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Budget $Budget
     * @return mixed
     */
    public function view(User $user, Budget $budget)
    {
        return $budget->user_id == $user->id;
    }

    /**
     * Determine whether the user can create Budgets.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Budget.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Budget $Budget
     * @return mixed
     */
    public function update(User $user, Budget $budget)
    {
        return $budget->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the Budget.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Budget $Budget
     * @return mixed
     */
    public function delete(User $user, Budget $budget)
    {
        return $budget->user_id == $user->id;
    }
}

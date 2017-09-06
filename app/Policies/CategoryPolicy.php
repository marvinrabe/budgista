<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Category.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Category $Category
     * @return boolean
     */
    public function view(User $user, Category $category)
    {
        return $user->can('view', $category->budget);
    }

    /**
     * Determine whether the user can create Categorys.
     *
     * @param  \App\Models\User $user
     * @return boolean
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Category.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Category $Category
     * @return boolean
     */
    public function update(User $user, Category $category)
    {
        return $user->can('update', $category->budget);
    }

    /**
     * Determine whether the user can delete the Category.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Category $Category
     * @return boolean
     */
    public function delete(User $user, Category $category)
    {
        return $user->can('update', $category->budget);
    }
}

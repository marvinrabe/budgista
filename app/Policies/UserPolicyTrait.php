<?php

namespace App\Policies;

use App\User;

trait UserPolicyTrait
{

    public function view(User $user, $model)
    {
        return $model->user_id == $user->id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, $model)
    {
        return $model->user_id == $user->id;
    }

    public function delete(User $user, $model)
    {
        return $model->user_id == $user->id;
    }

}

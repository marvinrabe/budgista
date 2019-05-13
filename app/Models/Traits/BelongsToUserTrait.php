<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Scopes\UserScope;

trait BelongsToUserTrait
{

    protected static function bootBelongsToUserTrait()
    {
        static::addGlobalScope(new UserScope());

        static::creating(function ($model) {
            $model->user_id = $model->user_id ?: auth()->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ownedBy(User $user)
    {
        return $user->id === $this->user_id;
    }

}

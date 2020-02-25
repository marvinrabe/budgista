<?php

namespace App\Traits;

use App\User;
use App\Scopes\UserScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToUser
{

    protected static function bootBelongsToUser()
    {
        static::addGlobalScope(new UserScope());

        static::creating(function ($model) {
            $model->user_id = $model->user_id ?: Auth::id();
        });
    }

    public function initializeBelongsToUser()
    {
        $this->guarded[] = ['user_id'];
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

<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Scopes\UserScope;

trait BelongsToUserTrait
{

    protected static function bootBelongsToUserTrait()
    {
        static::addGlobalScope(new UserScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

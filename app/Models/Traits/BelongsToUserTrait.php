<?php

namespace App\Models\Traits;

trait BelongsToUserTrait
{

    public function user()
    {
        return $this->belongsTo('App\Models\Budget');
    }

}

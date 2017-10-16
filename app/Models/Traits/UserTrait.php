<?php

namespace App\Models\Traits;

trait UserTrait
{

    public function user()
    {
        return $this->belongsTo('App\Models\Budget');
    }

}

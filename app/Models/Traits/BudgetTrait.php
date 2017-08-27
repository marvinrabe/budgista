<?php

namespace App\Models\Traits;

trait BudgetTrait
{

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget');
    }

}

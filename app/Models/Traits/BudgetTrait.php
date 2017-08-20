<?php

namespace App\Models\Traits;

use App\Models\Scopes\BudgetScope;

trait BudgetTrait
{

    public static function bootBudgetTrait()
    {
        static::addGlobalScope(new BudgetScope);
    }

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget');
    }

}

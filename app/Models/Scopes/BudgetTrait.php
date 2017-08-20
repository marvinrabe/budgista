<?php

namespace App\Models\Scopes;

trait BudgetTrait
{

    public static function bootBudgetTrait()
    {
        static::addGlobalScope(new BudgetScope);
    }

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }

}

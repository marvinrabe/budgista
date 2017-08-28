<?php

namespace App\Models\Traits;

trait BudgetTrait
{

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget');
    }

    public function scopeInBudget($query, $budget)
    {
        return $query->where('budget_id', $budget->id);
    }

}

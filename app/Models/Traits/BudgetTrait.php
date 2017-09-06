<?php

namespace App\Models\Traits;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Collection;

trait BudgetTrait
{

    public function budget()
    {
        return $this->belongsTo('App\Models\Budget');
    }

    /**
     * Returns all Entities belonging to the specified Worksheet.
     *
     * @param $query
     * @param $budget Budget
     * @return Collection
     */
    public function scopeInBudget($query, $budget)
    {
        return $query->where('budget_id', $budget->id);
    }

}

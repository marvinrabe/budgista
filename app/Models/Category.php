<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\AutoBudget\AutoBudget;
use App\Models\Traits\BelongsToUserTrait;
use App\Month;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Budget[] $budgets
 * @property Transaction[] $transactions
 */
class Category extends Model
{

    use UuidModelTrait,
        BelongsToUserTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('sort', 'asc');
        });
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function budgets()
    {
        return $this->hasMany('App\Models\Budget');
    }

    /**
     * Returns the budget of this category for a specific month.
     *
     * @param Month $month
     * @return Budget
     */
    public function budgetIn(Month $month)
    {
        return Budget::firstOrNew([
            'category_id' => $this->id,
            'month' => (string)$month
        ]);
    }

}
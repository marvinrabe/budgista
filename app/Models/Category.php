<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BudgetTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use UuidModelTrait, BudgetTrait;

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
        return $this->hasMany('App\Models\CategoryBudget');
    }

    public function month($month) {
        return CategoryBudget::firstOrNew(['budget_id' => $this->budget->id, 'category_id' => $this->id, 'month' => $month]);
    }

}
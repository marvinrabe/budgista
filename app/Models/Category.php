<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use UuidModelTrait, BudgetTrait;

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
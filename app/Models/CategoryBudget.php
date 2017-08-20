<?php

namespace App\Models;

use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;

class CategoryBudget extends Model
{

    use BudgetTrait;

    public $timestamps = false;

    protected $fillable = ['budget_id', 'category_id', 'month'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}

<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\AutoBudget\AutoBudget;
use App\Models\Traits\UserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use UuidModelTrait, UserTrait;

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

    public function month($month)
    {
        return CategoryBudget::firstOrNew([
            'category_id' => $this->id,
            'month' => $month
        ]);
    }

}
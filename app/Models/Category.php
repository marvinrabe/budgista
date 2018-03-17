<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BelongsToUserTrait;
use App\Budget\Month;
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

    protected $fillable = ['name', 'sort'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('sort', 'asc');
        });

        static::creating(function (Category $model) {
            $model->determineSort();
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
    public function budget(Month $month)
    {
        return Budget::firstOrCreate([
            'category_id' => $this->id,
            'month' => $month
        ]);
    }

    /**
     * Sets sort to highest available + 1
     */
    public function determineSort()
    {
        $this->sort = $this->where('user_id', '=', $this->user_id)->max('sort') + 1;
    }
}
<?php

namespace App\Models;

use App\Models\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Budget\Month;
use App\Models\Traits\BelongsToUser;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasUuidKey,
        BelongsToUser;

    protected $fillable = [
        'name',
        'sort',
        'group_id'
    ];

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
        return $this->hasMany(Transaction::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Returns the budget of this category for a specific month.
     * @param  Month  $month
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
        $this->sort = Category::withoutGlobalScope(UserScope::class)
                ->where('user_id', '=', $this->user_id)
                ->max('sort') + 1;
    }
}

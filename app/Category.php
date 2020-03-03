<?php

namespace App;

use App\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Month;
use App\Traits\BelongsToUser;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    use HasUuidKey,
        BelongsToUser;

    protected $appends = [
        'links'
    ];

    protected $fillable = [
        'name',
        'description',
        'sort'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('sort');
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

    public function getLinksAttribute()
    {
        return [
            'edit' => URL::route('categories.edit', $this),
            'update' => URL::route('categories.update', $this),
            'destroy' => URL::route('categories.destroy', $this)
        ];
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

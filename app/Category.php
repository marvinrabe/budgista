<?php

namespace App;

use App\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
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

    public function budget(Month $month)
    {
        return either(
            $this->budgets->firstWhere('month', (string) $month),
            fn() => $this->budgets()->make([
                'month' => $month
            ])
        );
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

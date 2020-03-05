<?php

namespace App;

use App\Scopes\UserScope;
use App\Traits\HasCompositeKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Budget extends Model
{
    protected $attributes = [
        'amount' => 0
    ];

    protected $with = [
        'activitySum', 'previousBudgetSum', 'previousActivitySum'
    ];

    use HasCompositeKey;

    public $timestamps = false;

    protected $fillable = ['category_id', 'month', 'amount'];

    protected $primaryKey = ['category_id', 'month'];

    protected $casts = [
        'amount' => 'int'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function related()
    {
        return $this->hasManyThrough(
            Budget::class,
            Category::class,
            'id',
            'category_id',
            'category_id',
            'id'
        );
    }

    public function transactions()
    {
        return $this
            ->hasManyThrough(
                Transaction::class,
                Category::class,
                'id',
                'category_id',
                'category_id',
                'id'
            )
            ->whereHas('account', fn($query) => $query->where('tracking', false));
    }

    public function upcomingTransactions()
    {
        return $this
            ->transactions()
            ->where('date', '>=', $this->month->firstDay());
    }

    public function getMonthAttribute($value)
    {
        return Month::fromString($value);
    }

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = (string) $value;
    }

    public function previousBudgetSum()
    {
        return $this->related()
            ->selectRaw('SUM(amount) as aggregate, categories.id')
            ->where('month', '<=', $this->month->previous()->lastDay())
            ->groupBy('categories.id');
    }

    public function getPreviousBudgetAttribute()
    {
        if (!$this->relationLoaded('previousBudgetSum')) {
            $this->load('previousBudgetSum');
        }

        $related = $this->getRelation('previousBudgetSum')->first();

        return $related ? (int) $related->aggregate : 0;
    }

    public function previousActivitySum()
    {
        return $this->transactions()
            ->selectRaw('SUM(amount) as aggregate, categories.id')
            ->where('date', '<=', $this->month->previous()->lastDay())
            ->groupBy('categories.id');
    }

    public function getPreviousActivityAttribute()
    {
        if (!$this->relationLoaded('previousActivitySum')) {
            $this->load('previousActivitySum');
        }

        $related = $this->getRelation('previousActivitySum')->first();

        return $related ? (int) $related->aggregate : 0;
    }

    public function getPreviousMonthAttribute()
    {
        return $this->previousBudget + $this->previousActivity;
    }

    public function activitySum()
    {
        return $this->transactions()
            ->selectRaw('SUM(amount) as aggregate, categories.id')
            ->whereBetween('date', [
                $this->month->firstDay(),
                $this->month->lastDay()
            ])
            ->groupBy('categories.id');
    }

    public function getActivityAttribute()
    {
        if (!$this->relationLoaded('activitySum')) {
            $this->load('activitySum');
        }

        $related = $this->getRelation('activitySum')->first();

        return $related ? (int) $related->aggregate : 0;
    }

    public function getAvailableAttribute()
    {
        return $this->previousMonth + $this->amount + $this->activity;
    }

    public function getRecommendedBudgetAttribute()
    {
        return (new Forecast(
            $this->month,
            $this->upcomingTransactions,
            $this->previousMonth
        ))->recommendedBudget();
    }

}

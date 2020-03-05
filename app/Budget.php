<?php

namespace App;

use App\Traits\HasCompositeKey;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $attributes = [
        'amount' => 0
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
        return $this->hasManyThrough(
            Transaction::class,
            Category::class,
            'id',
            'category_id',
            'category_id',
            'id'
        );
    }

    public function upcomingTransactions()
    {
        return $this
            ->transactions()
            ->whereHas('account', fn($query) => $query->where('tracking', false))
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

    public function getPreviousMonthAttribute()
    {
        $budget = $this->related()
            ->where('month', '<', (string) $this->month)
            ->sum('amount');

        $activity = $this->transactions()
            ->whereHas('account', function ($query) {
                $query->where('tracking', false);
            })
            ->where('date', '<=', $this->month->previous()->lastDay())
            ->sum('amount');

        return $budget + $activity;
    }

    public function getActivityAttribute()
    {
        return $this->transactions()
            ->whereHas('account', function ($query) {
                $query->where('tracking', false);
            })
            ->whereBetween('date', [
                $this->month->firstDay(),
                $this->month->lastDay()
            ])
            ->sum('amount');
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

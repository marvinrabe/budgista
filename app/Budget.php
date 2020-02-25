<?php

namespace App;

use App\Forecast;
use App\Month;
use App\Traits\HasCompositeKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property Category $category
 */
class Budget extends Model implements \JsonSerializable
{

    use HasCompositeKey;

    public $timestamps = false;

    protected $fillable = ['category_id', 'month', 'amount'];

    protected $primaryKey = ['category_id', 'month'];

    public function getMonthAttribute($value)
    {
        return Month::fromString($value);
    }

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = (string) $value;
    }

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

    public function previousMonth()
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

    public function activity()
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

    public function available()
    {
        return $this->previousMonth() + $this->amount + $this->activity();
    }

    public function recommendedBudget()
    {
        $upcomingTransactions = $this->category
            ->transactions()
            ->whereHas('account', function ($query) {
                $query->where('tracking', false);
            })
            ->where('date', '>=', $this->month->firstDay())
            ->get();

        return (new Forecast(
            $this->month,
            $upcomingTransactions,
            $this->previousMonth()
        ))->recommendedBudget();
    }

    function jsonSerialize()
    {
        return [
            'month' => (string) $this->month,
            'previousMonth' => (int) $this->previousMonth(),
            'budget' => (int) $this->amount,
            'activity' => (int) $this->activity(),
            'available' => (int) $this->available(),
            'recommendedBudget' => (int) $this->recommendedBudget()
        ];
    }

}

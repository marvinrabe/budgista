<?php

namespace App\Models;

use App\Budget\Foresight;
use App\Budget\Month;
use App\Models\Traits\HasCompositeKey;
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

    private function previousMonthBudget()
    {
        return DB::table('budgets')
            ->join('categories', 'categories.id', '=', 'budgets.category_id')
            ->where([
                ['month', '<', (string) $this->month],
                ['category_id', '=', $this->category_id]
            ])
            ->sum('amount');
    }

    public function previousMonthAvailable()
    {
        $activity = $this->category
            ->transactions()
            ->whereHas('account', function ($query) {
                $query->where('tracking', false);
            })
            ->where('date', '<=', $this->month->previous()->lastDay())
            ->sum('amount');
        return $this->previousMonthBudget() + $activity;
    }

    public function activity()
    {
        return $this->category
            ->transactions()
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
        return $this->previousMonthAvailable() + $this->amount + $this->activity();
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

        return (new Foresight(
            $this->month,
            $upcomingTransactions,
            $this->previousMonthAvailable()
        ))->recommendedBudget();
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->category->id,
            'name' => $this->category->name,
            'month' => (string) $this->month,
            'previousMonth' => (int) $this->previousMonthAvailable(),
            'budget' => (int) $this->amount,
            'activity' => (int) $this->activity(),
            'available' => (int) $this->available(),
            'recommendedBudget' => (int) $this->recommendedBudget()
        ];
    }

}

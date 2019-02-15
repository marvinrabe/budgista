<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BelongsToUserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Transaction[] $transactions
 */
class Account extends Model
{

    use UuidModelTrait,
        BelongsToUserTrait;

    protected $fillable = [
        'name',
        'tracking',
        'icon'
    ];

    protected $casts = [
        'tracking' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('name', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute()
    {
        return $this->unclearedBalance();
    }

    public function clearedBalance()
    {
        return (int)$this
            ->transactions()
            ->where('cleared', '=', true)
            ->sum('amount');
    }

    public function unclearedBalance()
    {
        return (int)$this
            ->transactions()
            ->where([
                ['cleared', '=', false],
                ['date', '<=', Carbon::now()]
            ])
            ->sum('amount');
    }

    public function workingBalance()
    {
        return (int)$this
            ->transactions()
            ->where('date', '<=', Carbon::now())
            ->sum('amount');
    }

    public function reconcile($newBalance)
    {
        $difference = $newBalance - $this->workingBalance();

        $this->transactions()->create([
            'date' => Carbon::now(),
            'payee' => trans('action.reconciliation'),
            'amount' => $difference
        ]);

        $this->transactions()->update(['cleared' => true]);
    }

}

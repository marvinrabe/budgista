<?php

namespace App;

use App\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;

class Account extends Model
{
    use HasUuidKey,
        BelongsToUser;

    protected $fillable = [
        'name',
        'tracking',
        'icon'
    ];

    protected $appends = ['links'];

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

    public function getLinksAttribute()
    {
        return [
            'show' => URL::route('accounts.show', $this, false),
            'future' => URL::route('accounts.future', $this, false),
            'edit' => URL::route('accounts.edit', $this),
            'update' => URL::route('accounts.update', $this),
            'destroy' => URL::route('accounts.destroy', $this),
            'transactions' => [
                'create' => URL::route('transactions.create', ['account' => $this])
            ]
        ];
    }

    public function getBalanceAttribute()
    {
        return (int) $this
            ->transactions()
            ->where('date', '<=', Carbon::now())
            ->sum('amount');
    }

    public function getClearedBalanceAttribute()
    {
        return (int) $this
            ->transactions()
            ->where('paid', '=', true)
            ->sum('amount');
    }

    public function getOutstandingBalanceAttribute()
    {
        return (int) $this
            ->transactions()
            ->current()
            ->where('paid', '=', false)
            ->sum('amount');
    }

    public function reconcile($newBalance)
    {
        $difference = $newBalance - $this->balance;

        $this->transactions()->create([
            'date' => Carbon::now(),
            'payee' => trans('action.reconciliation'),
            'amount' => $difference
        ]);

        $this->transactions()->update(['paid' => true]);
    }

}

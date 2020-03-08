<?php

namespace App;

use App\Traits\HasUuidKey;
use App\Recurring;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Transaction extends Model
{
    use HasUuidKey,
        BelongsToUser;

    protected $appends = ['links', 'recurrence'];

    protected $fillable = [
        'date',
        'category_id',
        'account_id',
        'payee',
        'amount',
        'cleared',
        'notes'
    ];

    protected $hidden = ['rrule'];

    protected $casts = [
        'amount' => 'int',
        'recurring' => 'bool',
        'cleared' => 'bool',
        'date' => 'date:Y-m-d'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>', now());
    }

    public function scopeCurrent($query)
    {
        return $query->where('date', '<=', now());
    }

    public function getLinksAttribute()
    {
        return [
            'edit' => URL::route('transactions.edit', $this),
            'update' => URL::route('transactions.update', $this),
            'destroy' => URL::route('transactions.destroy', $this)
        ];
    }

    public function getRecurrenceAttribute(): ?Recurring
    {
        if (!$this->recurring) {
            return null;
        }

        return Recurring::fromString($this->rrule);
    }

    public function setRecurrenceAttribute($value)
    {
        if (Arr::has($value, ['frequency', 'interval'])) {
            $this->recurring = true;
            $this->rrule = (string) Recurring::fromRequest($value);
            return;
        }

        $this->recurring = false;
        $this->rrule = null;
    }

    public function processRecurring()
    {
        $transactions = optional($this->recurrence)->generateOccurrences($this);

        DB::transaction(function () use ($transactions) {
            foreach ($transactions as $transaction) {
                $transaction->save();
            }
        });

        return $transactions;
    }

}

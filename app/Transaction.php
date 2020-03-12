<?php

namespace App;

use App\Scopes\UserScope;
use App\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Transaction extends Model
{
    use HasUuidKey,
        BelongsToUser;

    protected $appends = ['links', 'recurrence'];

    protected $attributes = ['recurring' => false];

    protected $fillable = [
        'date',
        'category_id',
        'account_id',
        'payee',
        'amount',
        'paid',
        'notes'
    ];

    protected $hidden = ['rrule'];

    protected $casts = [
        'amount' => 'int',
        'recurring' => 'bool',
        'paid' => 'bool',
        'date' => 'date:Y-m-d'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function targetAccount()
    {
        return $this->hasOneThrough(
            Account::class,
            Transaction::class,
            'id', // Foreign key on trans table...
            'id', // Foreign key on account table...
            'related_id', // Local key on this table...
            'account_id' // Local key on trans table...
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function related()
    {
        return $this->belongsTo(Transaction::class)->withoutGlobalScope(UserScope::class);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>', now());
    }

    public function scopeCurrent($query)
    {
        return $query->where('date', '<=', now());
    }

    public function scopeNoTransfers($query)
    {
        return $query->whereNull('related_id');
    }

    public function scopeIncome($query)
    {
        return $query->noTransfers()->where('amount', '>', 0);
    }

    public function scopeExpenses($query)
    {
        return $query->noTransfers()->where('amount', '<', 0);
    }

    public function scopeInMonth($query, Month $month)
    {
        return $query->whereBetween('date', [
            $month->firstDay(),
            $month->lastDay()
        ]);
    }

    public function getLinksAttribute()
    {
        return [
            'edit' => URL::route('transactions.edit', $this)
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
        $recurring = $this->recurrence;

        if (!$this->family) {
            $this->family = $this->id;
        }
        $this->recurrence = null;

        if ($this->related_id && $this->amount < 0) {
            $this->save();
            return;
        }

        DB::transaction(function () use ($recurring) {
            $transactions = $recurring->generateOccurrences($this);

            $transactions->last()->recurrence = $recurring->toArray();

            $transactions->each(function (Transaction $transaction) {
                $transaction->save();
                optional(
                    $this->related,
                    fn($related) => $transaction->createRelated($related->account_id)
                );
            });

            $this->save();
        });
    }

    public function createRelated($account_id)
    {
        $oldRelation = null;
        if ($this->related) {
            $oldRelation = $this->related;
        }

        $related = $this->replicate(['amount', 'account_id', 'paid', 'related_id']);
        $related->account_id = $account_id;
        $related->amount = -1 * $this->amount;
        if ($oldRelation) {
            $related->paid = $oldRelation->paid;
        }
        $related->related_id = $this->id;
        $related->save();

        $this->related_id = $related->id;
        $this->setRelation('related', $related);
        $this->save();

        if ($oldRelation) {
            $oldRelation->delete();
        }
    }

}

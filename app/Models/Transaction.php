<?php

namespace App\Models;

use App\Models\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToUser;
use App\RecurringGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use RRule\RRule;

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
        'cleared'
    ];

    protected $hidden = ['rrule'];

    protected $casts = [
        'amount' => 'int',
        'recurring' => 'bool',
        'cleared' => 'bool',
        'date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('date', 'desc');
        });
    }

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

    public function getRecurrenceAttribute()
    {
        if (!$this->recurring) {
            return null;
        }

        $dbRule = new RRule($this->rrule);

        return new \App\RRule(array_merge($dbRule->getRule(), ['dtstart' => $this->date]));
    }

    public function setRecurrenceAttribute($value)
    {
        if (Arr::has($value, ['frequency', 'interval'])) {
            $this->recurring = true;
            $this->rrule = (string) \App\RRule::fromRequest($value);
            return;
        }

        $this->recurring = false;
        $this->rrule = null;
    }

    public static function processRecurring($transaction)
    {
        $generator = new RecurringGenerator();

        $transactions = collect($generator->generateOccurrences($transaction));

        DB::transaction(function () use ($transactions) {
            foreach ($transactions as &$transaction) {
                $transaction->save();
            }
        });

        return $transactions;
    }

    public function getAmount()
    {
        return abs($this->amount);
    }

    public function getCategories()
    {
        return [
            [
                'category' => $this->category,
                'amount' => $this->getAmount()
            ]
        ];
    }

    public function getFromSubject()
    {
        if ($this->amount < 0) {
            return $this->getAccountSubject();
        }
        return $this->getPayeeSubject();
    }

    public function getToSubject()
    {
        if ($this->amount >= 0) {
            return $this->getAccountSubject();
        }
        return $this->getPayeeSubject();
    }

    protected function getPayeeSubject()
    {
        return $this->getSubject(
            new Payee($this->payee),
            true
        );
    }

    protected function getAccountSubject()
    {
        return $this->getSubject(
            $this->account,
            $this->cleared
        );
    }

    protected function getSubject($subject, $cleared)
    {
        return [
            'subject' => $subject,
            'cleared' => $cleared
        ];
    }

    public function getRecurrence()
    {
        if (!$this->recurring) {
            return null;
        }

        return $this->rrule;
    }

}

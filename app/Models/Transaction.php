<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;
use RRule\RRule;

/**
 * @property Account $account
 * @property Category $category
 */
class Transaction extends Model
{

    use UuidModelTrait, BelongsToUserTrait;

    protected $fillable = [
        'date',
        'category_id',
        'account_id',
        'payee',
        'amount',
        'cleared'
    ];

    protected $dates = ['date'];

    protected $casts = [
        'amount' => 'int',
        'recurring' => 'bool',
        'cleared' => 'bool'
    ];

    public function getRruleAttribute($value)
    {
        if (!$this->attributes['recurring']) {
            return null;
        }

        $dbRule = new RRule($value);

        return new RRule(array_merge($dbRule->getRule(), ['dtstart' => $this->attributes['date']]));
    }

    public function setRruleAttribute($value)
    {
        /**
         * @var RRule $value ;
         */
        if ($value instanceof RRule) {
            $this->attributes['recurring'] = true;
            $this->attributes['rrule'] = (string) $value;
            return;
        }

        $this->attributes['recurring'] = false;
        $this->attributes['rrule'] = true;
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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

}

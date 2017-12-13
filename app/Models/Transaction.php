<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use RRule\RRule;

/**
 * @property Account $account
 * @property Category $category
 */
class Transaction extends Model
{

    use UuidModelTrait;

    protected $fillable = [
        'date',
        'category_id',
        'account_id',
        'payee',
        'amount'
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
            return false;
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
            $this->attributes['rrule'] = (string)$value;
            return;
        }

        $this->attributes['recurring'] = false;
        $this->attributes['rrule'] = true;
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
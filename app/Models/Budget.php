<?php

namespace App\Models;

use App\Models\Traits\BelongsToUserTrait;
use App\Models\Traits\HasCompositePrimaryKeyTrait;
use App\Budget\Month;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Category $category
 */
class Budget extends Model
{

    use BelongsToUserTrait,
        HasCompositePrimaryKeyTrait;

    public $timestamps = false;

    protected $fillable = ['category_id', 'month', 'amount'];

    protected $primaryKey = ['category_id', 'month'];

    public function getMonthAttribute($value)
    {
        return Month::fromString($value);
    }

    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = (string)$value;
    }

    protected $casts = [
        'amount' => 'int'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}

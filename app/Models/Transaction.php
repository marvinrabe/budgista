<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BudgetTrait;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use UuidModelTrait, BudgetTrait;

    protected $dates = ['date'];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use UuidModelTrait, BudgetTrait;

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
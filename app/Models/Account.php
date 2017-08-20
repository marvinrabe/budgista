<?php

namespace App\Models;

use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Account extends Model
{

    use UuidModelTrait, BudgetTrait;

    public function transactions()
    {
        return $this->hasMany('App\Models\Transactions');
    }

}

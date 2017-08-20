<?php

namespace App\Models;

use App\Models\Traits\BudgetTrait;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Account extends Model
{

    use UuidModelTrait, BudgetTrait;

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function clearedBalance()
    {
        return $this->transactions()->where('cleared', '=', true)->sum('amount');
    }

    public function unclearedBalance()
    {
        return $this->transactions()->where('cleared', '=', false)->sum('amount');
    }

    public function workingBalance()
    {
        return $this->transactions()->sum('amount');
    }

}

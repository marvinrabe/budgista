<?php

namespace App\Models;

use App\Models\Traits\BudgetTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Account extends Model
{

    use UuidModelTrait, BudgetTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('name', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

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
        return $this->transactions()->where([['cleared', '=', false], ['date','<=', Carbon::now()]])->sum('amount');
    }

    public function workingBalance()
    {
        return $this->transactions()->sum('amount');
    }

}

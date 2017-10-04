<?php

namespace App\Models;

use App\Month;
use App\Sheet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Budget extends Model
{

    use UuidModelTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('name', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function month(Month $month)
    {
        return new Sheet($this, $month);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Budget extends Model
{
    use UuidModelTrait;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

}

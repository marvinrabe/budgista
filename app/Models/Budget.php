<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Budget extends Model
{

    use UuidModelTrait;

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

}

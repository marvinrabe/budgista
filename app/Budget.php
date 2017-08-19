<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }

}

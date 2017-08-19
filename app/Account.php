<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Account extends Model
{
    use UuidModelTrait;

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }

}

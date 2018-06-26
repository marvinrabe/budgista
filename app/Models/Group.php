<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    use UuidModelTrait,
        BelongsToUserTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort'
    ];

}

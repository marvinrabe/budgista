<?php

namespace App\Models;

use App\Month;
use App\Sheet;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Alsofronie\Uuid\UuidModelTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

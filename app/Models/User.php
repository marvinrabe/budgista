<?php

namespace App\Models;

use App\Month;
use App\MonthlyBudget;
use App\Services\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property Account[] $accounts
 * @property Category[] $categories
 */
class User extends Authenticatable
{

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'language', 'locale', 'currency'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function budget(Month $month)
    {
        return new MonthlyBudget($this, $month);
    }

}

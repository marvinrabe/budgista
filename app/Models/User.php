<?php

namespace App\Models;

use App\Budget\Month;
use App\Budget\Sheet;
use App\Mail\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property Account[] $accounts
 * @property Category[] $categories
 * @property bool $is_admin
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
        'password', 'remember_token', 'is_admin'
    ];

    protected $casts = [
        'is_admin' => 'bool'
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
        return new Sheet($this, $month);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }

    public function isActive() {
        $oldTransactionCount = $this
            ->transactions()
            ->whereBetween('date', [Carbon::now()->subDays(31), Carbon::now()])
            ->count();

        $futureTransactionCount = $this
            ->transactions()
            ->where('date', '>', Carbon::now())
            ->count();

        return ($oldTransactionCount - $futureTransactionCount) > 0;
    }

}

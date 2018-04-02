<?php

namespace App\Models;

use App\Budget\Month;
use App\Budget\Sheet;
use App\Mail\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property Account[] $accounts
 * @property Category[] $categories
 * @property bool $is_admin
 */
class User extends Authenticatable implements JWTSubject
{

    use Notifiable;

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

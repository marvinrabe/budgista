<?php

namespace App\Models;

use App\Auth\EmailTokenRepository;
use App\Budget\Month;
use App\Budget\Sheet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property Account[] $accounts
 * @property Category[] $categories
 */
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language',
        'locale',
        'currency',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function budget(Month $month)
    {
        return new Sheet($this, $month);
    }

    public function terminate($reason = null)
    {
        DeletedUser::create([
            'feedback' => $reason,
            'created_at' => $this->created_at
        ]);

        $this->delete();
    }

    /**
     * Sends verification email.
     */
    public function sendEmailVerificationNotification()
    {
        $token = resolve(EmailTokenRepository::class)->get($this->email);

        $this->notify(new \App\Notifications\VerifyEmail($token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

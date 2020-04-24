<?php

namespace App;

use App\Mails\UserDeleted;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $appends = ['has_password', 'is_newbie', 'premium'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'last_login_at' => 'datetime',
        'subscription_ends_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'password',
        'language',
        'locale',
        'currency',
        'last_login_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getIsNewbieAttribute()
    {
        return optional($this->created_at)->diffInDays() <= 6;
    }


    public function getPremiumAttribute()
    {
        if (!in_array($this->subscription_state, [null, 'active', 'cancelled'])) {
            return false;
        }

        if (!$this->subscription_ends_at) {
            return false;
        }

        return $this->subscription_ends_at->endOfDay()->isFuture();
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

    public function budgets()
    {
        return $this->hasManyThrough(Budget::class, Category::class);
    }

    public function getHasPasswordAttribute()
    {
        return $this->password !== null;
    }

    public function terminate($reason = null)
    {
        $this->delete();

        if (!empty($reason)) {
            Mail::to(config('app.email'))->send(new UserDeleted($reason));
        }
    }
}

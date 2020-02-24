<?php

namespace App\Models;

use App\Budget\Month;
use App\Budget\Sheet;
use App\Mail\UserDeleted;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $appends = ['has_password'];

    protected $casts = [
        'email_verified_at' => 'datetime'
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

    public function getHasPasswordAttribute() {
        return $this->password !== null;
    }

    public function budget(Month $month)
    {
        return new Sheet($this, $month);
    }

    public function terminate($reason = null)
    {
        $deletedUserLog = DeletedUser::create([
            'feedback' => $reason,
            'created_at' => $this->created_at
        ]);

        $this->delete();

        if (!empty($reason)) {
            Mail::to(config('app.email'))->send(new UserDeleted($deletedUserLog));
        }
    }
}

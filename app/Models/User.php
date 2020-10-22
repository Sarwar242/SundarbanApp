<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\PasswordResetNotification;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email','phone', 'password','is_company',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token){
        $this->notify(new PasswordResetNotification($token));
    }



    public function username()
    {
        return $this->phone;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function followings()
    {
        return $this->hasMany(Company::class);
    }
}

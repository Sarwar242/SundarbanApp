<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use App\Notifications\PasswordResetNotification;


class Admin  extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
         'email', 'password','first_name',
         'last_name', 'username','type','ban',
         'nid', 'phone1','phone2','image',
         'street', 'location','about','zipcode',
         'union_id', 'upazilla_id','district_id','division_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // public function sendPasswordResetNotification($token){
    //     $this->notify(new PasswordResetNotification($token));
    // }
    


}

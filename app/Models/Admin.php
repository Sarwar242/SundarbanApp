<?php

namespace App\Models;

use App\Notifications\AdminPasswordResetNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\HasApiTokens;

use App\Notifications\PasswordResetNotification;


class Admin  extends Authenticatable
{
    use Notifiable;//HasApiTokens

    protected $guard = 'admin';

    protected $fillable = [
         'email', 'password','first_name',
         'last_name', 'username','type','ban',
         'nid', 'phone1','phone2','image','admin_id',
         'street','bn_street', 'location','bn_location','about','bn_about','zipcode',
         'union_id', 'upazilla_id','district_id','division_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminPasswordResetNotification($token));
    }

    public function division()
   {
       return $this->belongsTo(Division::class);
   }


   public function district()
   {
       return $this->belongsTo(District::class);
   }
   public function upazilla()
   {
       return $this->belongsTo(Upazilla::class);
   }
   public function union()
   {
       return $this->belongsTo(Union::class);
   }
   public function admin()
   {
       return $this->belongsTo(Admin::class);
   }


    public static function admins()
    {
        $admins = Admin::latest()->paginate(10);

        return $admins;
    }

}

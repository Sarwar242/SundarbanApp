<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name','username','user_id','dob','image','nid','gender','phone','phone_hide',
        'about','bn_about','zipcode', 'street','bn_street', 'location','bn_location',
        'ban','hn','admin_id','union_id','upazilla_id','district_id','division_id'
   ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

   public static function customers()
   {
       $customers = Customer::latest()->paginate(10);

       return $customers;
   }
}

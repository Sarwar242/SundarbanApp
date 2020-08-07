<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name','user_id','dob','image','ban','hn','nid','gender','street',
        'zipcode','village','phone','admin_id','union_id','upazilla_id','district_id','division_id'
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
   
   public static function customers()
   {
       $customers = Customer::latest()->paginate(10);

       return $customers;
   }
}

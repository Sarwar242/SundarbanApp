<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'bn_name','owners_name','owners_nid','phone1','phone2','ban','image',
        'description','location','street','website','business_type','type',
        'zipcode','union_id','upazilla_id','district_id','division_id'
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }
}

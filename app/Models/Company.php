<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'bn_name', 'name','owners_name','owners_nid','phone1','phone2',
        'image','description','location','street',
        'zipcode','union_id','upazilla_id','district_id','division_id'
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }
}

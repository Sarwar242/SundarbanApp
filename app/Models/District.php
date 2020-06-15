<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude','website','division_id',
   ];

   
   public function division()
   {
       return $this->belongsTo(Division::class);
   }

   
   public function upazillas()
   {
       return $this->hasMany(Upazilla::class);
   }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upazilla extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude','district_id',
   ];

   
   public function district()
   {
       return $this->belongsTo(District::class);
   }

   
   public function unions()
   {
       return $this->hasMany(Union::class);
   }
}

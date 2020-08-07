<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude',
   ];

   
   
   public function districts()
   {
       return $this->hasMany(District::class);
   }
   
   
   public static function divisions()
   {
       $divisions= Division::latest()->paginate(10);
       return $divisions;
   }
   //orderBy('created_at','desc')->
}

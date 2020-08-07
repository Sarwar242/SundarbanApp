<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name','admin_id',
   ];


   public static function units()
   {
       $units = Unit::latest()->paginate(10);

       return $units;
   }
}

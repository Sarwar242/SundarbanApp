<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
   ];


   public static function units()
   {
       $units = Unit::all();

       return $units;
   }
}

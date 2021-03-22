<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
      'name',  'bn_name', 'longitude','latitude',
   ];



   public function districts()
   {
       return $this->hasMany(District::class);
   }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    public function customers()
    {
        return $this->hasMany(Company::class);
    }


   public static function divisions()
   {
       $divisions= Division::latest()->paginate(10);
       return $divisions;
   }
   //orderBy('created_at','desc')->


   public function products()
   {
       return $this->hasManyThrough(Product::class, Company::class)->orderBy('name', 'ASC');
   }
}

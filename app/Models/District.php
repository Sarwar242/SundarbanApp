<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'bn_name','name','longitude','latitude','website','admin_id','division_id',
   ];

   
   public function division()
   {
       return $this->belongsTo(Division::class);
   }

   
   public function upazillas()
   {
       return $this->hasMany(Upazilla::class);
   }

   public static function districts()
   {
       $districts= District::orderBy('division_id','asc')->paginate(10);
       return $districts;
   }
   //orderBy('created_at','desc')->
}

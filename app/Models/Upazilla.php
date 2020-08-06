<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upazilla extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude','admin_id','district_id',
   ];

   
   public function district()
   {
       return $this->belongsTo(District::class);
   }

   
   public function unions()
   {
       return $this->hasMany(Union::class);
   }


   
   public static function upazillas()
   {
       $upazillas= Upazilla::orderBy('district_id','asc')->paginate(10);
       return $upazillas;
   }
}

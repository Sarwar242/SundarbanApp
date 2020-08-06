<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude','admin_id','upazilla_id',
   ];

   
   public function upazilla()
   {
       return $this->belongsTo(Upazilla::class);
   }

   public static function unions()
   {
       $unions= Union::orderBy('upazilla_id','asc')->paginate(10);
       return $unions;
   }
}

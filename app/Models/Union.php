<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable = [
        'bn_name', 'name','longitude','latitude','upazilla_id',
   ];

   
   public function upazilla()
   {
       return $this->belongsTo(Upazilla::class);
   }

}

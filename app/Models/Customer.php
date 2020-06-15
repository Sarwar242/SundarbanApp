<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name','user_id','dob','image','hn','nid','gender','street',
        'zipcode','village','phone','union_id','upazilla_id','district_id','division_id'
   ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

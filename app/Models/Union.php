<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $fillable = [
      'name',  'bn_name', 'longitude','latitude','admin_id','upazilla_id',
    ];


    public function upazilla()
    {
        return $this->belongsTo(Upazilla::class);
    }
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public static function unions()
    {
        $unions= Union::orderBy('upazilla_id','asc')->paginate(10);
        return $unions;
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Company::class)->orderBy('name', 'ASC');
    }
}

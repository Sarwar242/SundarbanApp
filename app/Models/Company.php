<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'bn_name','owners_name','owners_nid','phone1','phone2','ban','image',
        'description','bn_description','street','bn_street', 'location','bn_location','website',
        'business_type','type','admin_id', 'zipcode',
        'union_id','upazilla_id','district_id','division_id','category_id','subcategory_id'
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function division()
   {
       return $this->belongsTo(Division::class);
   }

   public function category()
   {
       return $this->belongsTo(Category::class);
   }
   public function subcategory()
   {
       return $this->belongsTo(Subcategory::class);
   }

   public function district()
   {
       return $this->belongsTo(District::class);
   }
   public function upazilla()
   {
       return $this->belongsTo(Upazilla::class);
   }
   public function union()
   {
       return $this->belongsTo(Union::class);
   }

   
   public static function companies()
   {
       $companies = Company::latest()->paginate(10);

       return $companies;
   }
}

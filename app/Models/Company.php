<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'slug', 'bn_name', 'code','owners_name','owners_nid','phone1','phone2','ban','image',
        'description','bn_description','street','bn_street', 'location','bn_location','website',
        'business_type','type','admin_id', 'zipcode', 'open', 'close', 'off_day','phone_hide',
        'union_id','upazilla_id','district_id','division_id','category_id','subcategory_id'
   ];

   protected $times = ['open','close'];
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

   public function products()
   {
       return $this->hasMany(Product::class);
   }

   public function boost_records()
   {
       return $this->hasMany(Boost_Record::class);
   }

   public function boost()
   {
       return $this->hasOne(Boost::class);
   }


   public static function companies()
   {
       $companies = Company::latest()->paginate(10);

       return $companies;
   }
   public function admin()
   {
       return $this->belongsTo(Admin::class);
   }
   public function followers()
   {
       return $this->belongsToMany(User::class,'follows');
   }
   public function rated()
   {
       return $this->belongsToMany(User::class,'ratings');
   }
   public function ratings()
   {
       return $this->hasMany(Rating::class);
   }


   public static function slugComplete() {
    $companies = Company::all();
    foreach($companies as $company){
        $company->slug = Str::slug(str_replace( ' ', '-', $company->name));
        $company->code = 10000000+$company->id;
        $company->save();
    }
    return "Slug and Code added to all";
    }
}

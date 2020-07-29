<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code', 'name','bn_name','description','bn_description', 'price',
        'discount','quantity', 'type',
        'category_id','subcategory_id','unit_id','company_id'
   ];

   public function company()
   {
       return $this->belongsTo(Company::class);
   } 
   public function subcategory()
   {
       return $this->belongsTo(Subcategory::class);
   }
   public function category()
   {
       return $this->belongsTo(Category::class);
   }  
    
   public function unit()
   {
       return $this->belongsTo(Unit::class);
   }
   public function images()
   {
       return $this->hasMany(ProductImage::class);
   }
   
   
   
   public static function products()
   {
       $product = Product::paginate(5);

       return $product;
   }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'slug', 'bn_name','description','bn_description', 'price',
        'discount','quantity', 'type','admin_id',
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
   
   
   public static function generateProductCode(){
        $product22 = Product::latest('id')->first();
        
        if (!is_null($product22)) {
            $code = $product22->code;
            $removed2char = substr($code, 2);
            $generatedProductCode = $stpad = 'p_' . str_pad($removed2char + 1, 9, "0", STR_PAD_LEFT);
        } else {
            $generatedProductCode = 'p_' . str_pad(1, 9, "0", STR_PAD_LEFT);
        }
        return $generatedProductCode;
    }
   
   public static function products()
   {
       $product = Product::latest()->paginate(10);

       return $product;
   }

   public function admin()
   {
       return $this->belongsTo(Admin::class);
   }
   
   public static function slugComplete() {
    $categories = Product::all();
    foreach($categories as $category){
        $category->slug = Str::slug(str_replace( ' ', '-', $category->name));
        $category->save();
    }
    return "Slug add to all";
    }

}

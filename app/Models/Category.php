<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name','bn_name','description','bn_description', 'image','admin_id'
   ];

   

   public function subcategories()
   {
       return $this->hasMany(Subcategory::class);
   } 

    public function products()
   {
       return $this->hasMany(Product::class);
   }


   public static function categoies()
   {
       $categoies = Category::latest()->paginate(10);

       return $categoies;
   }
}

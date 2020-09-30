<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name','bn_name', 'slug','description','bn_description', 'image','admin_id'
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
       $categories = Category::latest()->paginate(10);

       return $categories;
   }

    public static function slugComplete() {
        $categories = Category::all();
        foreach($categories as $category){
            $category->slug = Str::slug(str_replace( ' ', '-', $category->name));
            $category->save();
        }
        return "Slug add to all";
    }

}

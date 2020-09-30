<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    protected $fillable = [
        'name', 'slug','bn_name','description','bn_description', 'image','admin_id','category_id',
   ];

   public function products()
   {
       return $this->hasMany(Product::class);
   }

   public function category()
   {
       return $this->belongsTo(Category::class);
   }

   public static function subcategoies()
   {
       $subcategoies = Subcategory::latest()->paginate(10);
       return $subcategoies;
   }
      
   public static function slugComplete() {
    $categories = Subcategory::all();
    foreach($categories as $category){
        $category->slug = Str::slug(str_replace( ' ', '-', $category->name));
        $category->save();
    }
    return "Slug add to all";
    }
}

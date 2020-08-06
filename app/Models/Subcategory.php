<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name','bn_name','description','bn_description', 'image','admin_id','category_id',
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
       $subcategoies = Subcategory::paginate(10);

       return $subcategoies;
   }
}

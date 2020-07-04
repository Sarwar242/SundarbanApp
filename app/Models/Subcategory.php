<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name','bn_name','description','bn_description', 'image','category_id',
   ];

   public function products()
   {
       return $this->hasMany(Product::class);
   }

   public function category()
   {
       return $this->belongsTo(Category::class);
   }
}

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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function productSearch(Request $request){
        $key = $request->key;
        $results = Product::where('name', 'like',"%{$key}%")
                           ->orWhere('description', 'like', "%{$key}%")
                           ->orWhere('bn_name', 'like',  "%{$key}%")
                           ->orWhere('bn_description', 'like',  "%{$key}%")
                           ->orWhere('type', 'like',  "%{$key}%")
                           ->orWhere('price', 'like',  "%{$key}%")
                           ->get();

        if(is_null($results))
            return response()->json([
                'success'=>false,
                'message'=>'Sorry No product found!',
            ]);

        return response()->json([
            'success'=>true,
            'products'=>$results,
           ]);
    }
}

<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    public function index()
    {
        try{
            $products = Product::all();
            foreach($products as $product ):
                $product->company;
            endforeach;
            
            return response()->json([
                "sucess"  => true,
                "product" => $products,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function store(Request  $request)
    {

        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'type' => 'sometimes|string',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'unit_id' => 'required',
            'company_id' => 'sometimes',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $product= new Product;
        $product->code =$request->code;
        $product->name =$request->name;
        $product->bn_name =$request->bn_name;
        $product->description =$request->description;
        $product->bn_description =$request->bn_description;
        $product->price =$request->price;
        $product->discount =$request->discount;
        $product->quantity =$request->quantity;
        $product->type =$request->type;
        $product->category_id =$request->category_id;
        $product->subcategory_id =$request->subcategory_id;
        $product->unit_id =$request->unit_id;
        $product->company_id =$request->company_id;
        $product->save();

        return response()->json([
            "sucess"  => true,
            "message" => "New product created!",
            "product" => $product
        ]);
    }

    public function show(Request  $request)
    {
        try{
            $product = Product::find($request->id);
            if(is_null($product))
            return response()->json([
                "sucess"  => false,
                "message" => "No Product Found!",
                
            ]);
            $company = $product->company;
            
            return response()->json([
                "sucess"  => true,
                "product" => $product,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }



   
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'type' => 'sometimes|string',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'unit_id' => 'required',
            'company_id' => 'sometimes',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $product = Product::find($request->id);
        $product->code =$request->code;
        $product->name =$request->name;
        $product->bn_name =$request->bn_name;
        $product->description =$request->description;
        $product->bn_description =$request->bn_description;
        $product->price =$request->price;
        $product->discount =$request->discount;
        $product->quantity =$request->quantity;
        $product->type =$request->type;
        $product->category_id =$request->category_id;
        $product->subcategory_id =$request->subcategory_id;
        $product->unit_id =$request->unit_id;
        $product->company_id =$request->company_id;
        $product->save();

        return response()->json([
            "sucess"  => true,
            "message" => "Product has been updated!",
            "product" => $product
        ]);
    }

    
    public function destroy(Request  $request)
    {
        try{
            $product = Product::find($request->id);
            $product->delete();
            return response()->json([
                "sucess"  => true,
                "message" => "Product has been deleted!",
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

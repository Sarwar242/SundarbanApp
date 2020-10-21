<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    
    public function index()
    {
        try{
            $products = Product::all();
            foreach($products as $product ):
                $product->company;
                foreach($product->images as $image):
                    $image->image;
                endforeach;
            endforeach;
            
            return response()->json([
                "success"  => true,
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
            //"image" => 'sometimes|file|image|max:3000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
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

            
            $pid= $product->id;
            $files = $request->file('image');
        
            if (!empty($files)):  
                $i=0;
                foreach($files as $file):
                    // dd($file) ;
                    $i++;
                    try{
                    $imagetbl = new ProductImage;
                    $imageName = time().$i.'.'.$file->extension();  
                    $file->move(public_path('storage/product'), $imageName);
                    $imagetbl->image =$imageName;
                    $imagetbl->product_id = $pid;
                    $imagetbl->priority = $i;
                    $imagetbl->save();   

                }catch(Exception $e){
                        ['message'=> ' '.$e.' '];
                }
                endforeach;
            endif;

            return response()->json([
                "success"  => true,
                "message" => "New product created!",
                "product" => $product,
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function show(Request  $request)
    {
        try{
            $product = Product::find($request->id);
            if(is_null($product))
            return response()->json([
                "success"  => false,
                "message" => "No Product Found!",
                
            ]);
            $company = $product->company;
            $images=$product->images;
            return response()->json([
                "success"  => true,
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
        //$product->company_id =$request->company_id;
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
            if(is_null($product))
            return response()->json([
                "sucess"  => false,
                "message" => "No Product Found!",
            ]);
        
            if (!empty($product->images)):
                $i=0;
                foreach ($product->images as $img):
                    File::delete(public_path('/storage/product/'.$img->image));
                endforeach;

                
            endif;
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

    public function deleteImage(Request $request)
    {
        $productimagetbl = ProductImage::find($request->id);
        if(is_null($productimagetbl))
            return response()->json([
                "sucess"  => false,
                "message" => "Image already deleted!", 
            ]);
       
        File::delete(public_path('/storage/product/'.$productimagetbl->image));
        $productimagetbl->delete();

        return response()->json([
            "sucess"  => true,
            "message" => "Product image has been deleted!",
        ]);

    }

    public function uploadImage(Request $request)
    {
        $files = $request->file('image');
       
        if(!empty($files)): 
            $i=0;
            foreach($files as $file):
                // dd($file) ;
                $i++;
                try{
                $imagetbl = new ProductImage;
                $imageName = time().$i.'.'.$file->extension(); 
                $file->move(public_path('storage/product'), $imageName);
                $imagetbl->image =$imageName;
                $imagetbl->product_id = $request->id;
                $imagetbl->priority = $i;
                $imagetbl->save();   

            }catch(Exception $e){
                    ['message'=> ' '.$e.' '];
            }
            endforeach;
            return response()->json([
                "sucess"  => true,
                "message" => "Product image has been uploaded!",
                
            ]);

        else:
            return response()->json([
                "sucess"  => false,
                "message" => "Product image  upload failed!",
                
            ]);

        endif;

    }
    


    
    public function setPriority(Request $request){
        try{
            $image=ProductImage::find($request->id);
            $image->priority = $request->priority;
            $image->save();
            return response()->json([
                "sucess"  => true,
                "message" => "Priority of the image has been set to ".$request->priority,
                
            ]);
        } catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

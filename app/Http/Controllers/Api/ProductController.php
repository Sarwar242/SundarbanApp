<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        try{
            $products = Product::orderBy('name', 'ASC')->get();
            foreach($products as $product ):
                $unit=$product->unit;
                $category = $product->category;
                $subcategory=$product->subcategory;
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
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'required|string',
            'bn_description' => 'nullable|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|numeric',
            'quantity' => 'required|numeric',
            'type' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'unit_id' => 'required',
            'company_id' => 'nullable',
            "image[]" => 'nullable|file|image|max:3000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $product= new Product;
            if(!is_null(Product::generateProductCode()))
                $product->code = Product::generateProductCode();
            else
                $product->code =0000;
            $product->name =$request->name;
            $product->bn_name =$request->bn_name;
            if(request()->has('description'))
                $product->description =$request->description;
            else
                $product->description = "N/A";
            $product->bn_description =$request->bn_description;
            $product->price =$request->price;

            if(!is_null($product->discount))
                $product->discount =$request->discount;
            else
                $product->discount=0;

            $product->quantity =$request->quantity;
            $product->type =$request->type;
            $product->category_id =$request->category_id;
            $product->subcategory_id =$request->subcategory_id;
            $product->unit_id =$request->unit_id;
            $product->company_id =$request->company_id;


            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Product::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $product->slug =$slug;
            $product->save();

            $pid= $product->id;
            $files = $request->file('image');

            if (!empty($files)):
                $i=0;
                foreach($files as $file):
                    $i++;
                    try{
                        $imagetbl = new ProductImage;
                        $imageName = time().$i.'.'.$file->extension();
                        $file->storeAs('/product',$imageName,'public');
                        $imagetbl->image =$imageName;
                        $imagetbl->product_id = $pid;
                        $imagetbl->priority = $i;
                        $imagetbl->save();
                    }catch(Exception $e){
                        return response()->json([
                            'success'=>false,
                            'message'=> ''.$e,
                        ]);
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

            $unit=$product->unit;
            $category = $product->category;
            $subcategory=$product->subcategory;
            $product->company;
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
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|numeric',
            'quantity' => 'nullable|numeric',
            'type' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'unit_id' => 'required',
            'company_id' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $product = Product::find($request->id);
        $slug_change =0;
        if($product->name!=$request->name){
            $slug_change=1;
        }
        $product->name =$request->name;
        $product->bn_name =$request->bn_name;
        $product->description =$request->description;
        $product->bn_description =$request->bn_description;

        if(!is_null($product->discount))
            $product->discount =$request->discount;
        else
            $product->discount=0;

        $product->price =$request->price;

        $product->quantity =$request->quantity;
        $product->type =$request->type;
        $product->category_id =$request->category_id;
        $product->subcategory_id =$request->subcategory_id;
        $product->unit_id =$request->unit_id;
        $product->company_id =$request->company_id;
        if($slug_change==1){
            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Product::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $product->slug =$slug;
        }

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
                foreach ($product->images as $img):
                   Storage::disk('public')->delete('product/'.$img->image);
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

        Storage::disk('public')->delete('product/'.$productimagetbl->image);
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
                $i++;
                try{
                $imagetbl = new ProductImage;
                $imageName = time().$i.'.'.$file->extension();
                $file->storeAs('/product',$imageName,'public');
                $imagetbl->image =$imageName;
                $imagetbl->product_id =$request->id;
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    public function index()
    {
        try{
            $categories = Category::orderBy('name', 'ASC')->get();
            foreach ($categories as $category) {
                $subcategories = $category->subcategories;
                $products=$category->products;
                if(!is_null($products))
                {
                    foreach ($products as $product) {
                        $product->unit;
                        $product->images;
                        $product->subcategory;
                        $product->company;
                    }
                }
            }
            return response()->json([
                "success"  => true,
                "categories" => $categories,
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
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $category= new Category;
            $category->name =$request->name;
            $category->bn_name =$request->bn_name;
            if(is_null($request->description)){
                $category->description ="N/A";
            }else{
                $category->description =$request->description;
            }
            if(is_null($request->bn_description)){
                $category->bn_description ="N/A";
            }else{
                $category->bn_description =$request->bn_description;
            }

            if(is_null($request->image)){
                $category->image="default.png";
            }else if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('/category',$imageName,'public');
                $category->image=$imageName;
            }

            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Category::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $category->slug =$slug;

            $category->save();

            return response()->json([
                "success"  => true,
                "message" => "New Category created!",
                "category" => $category,
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
            $category = Category::find($request->id);
            if(is_null($category))
            return response()->json([
                "success"  => false,
                "message" => "No Category Found!",

            ]);
            $category->subcategories;
            $products= $category->products;
            if(!is_null($products))
                {
                    foreach ($products as $product) {
                        $product->unit;
                        $product->images;
                        $product->subcategory;
                        $product->company;
                    }
                }

            return response()->json([
                "success"  => true,
                "category" => $category,
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
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $category = Category::find($request->id);
        $slug_change=0;
        if(request()->has('name')){
            if($category->name!=$request->name){
                $slug_change=1;
            }
            $category->name =$request->name;
        }
        if(request()->has('bn_name'))
            $category->bn_name =$request->bn_name;
        if(request()->has('description'))
            $category->description =$request->description;
        if(request()->has('bn_description'))
            $category->bn_description =$request->bn_description;
        if(request()->hasFile('image')){
            if(!is_null($category->image) && $category->image !="default.png" &&  $category->image !="default.jpg"){
                $exists = Storage::disk('public')->exists('category/'.$category->image);
                if($exists)
                    Storage::disk('public')->delete('category/'.$category->image);
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('/category',$imageName,'public');
            $category->image=$imageName;
        }

        if($slug_change==1){
            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Category::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $category->slug =$slug;
        }
        $category->save();

        return response()->json([
            "success"  => true,
            "message" => "Category has been updated!",
            "category" => $category
        ]);
    }


    public function destroy(Request  $request)
    {
        try{
            $category = Category::find($request->id);
            if(is_null($category))
                return response()->json([
                    "success"  => false,
                    "message" => "No Category Found!",
                ]);

            if (!is_null($category->image) && $category->image !="default.png" &&  $category->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('category/'.$category->image);
                if($exists)
                    Storage::disk('public')->delete('category/'.$category->image);
            }
            $category->delete();
            return response()->json([
                "success"  => true,
                "message" => "Category has been deleted!",
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

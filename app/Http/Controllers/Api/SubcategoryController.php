<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function index()
    {
        try{
            $subcategories = Subcategory::orderBy('priority', 'ASC')
                                        ->orderBy('bn_name', 'asc')
                                        ->get()
                                        ->sortByDESC('featured');
                                        
            foreach($subcategories as $subcategory ):
                $subcategory->category;
                $products=$subcategory->products;
                if(!is_null($products))
                {
                    foreach ($products as $product) {
                        $product->unit;
                        $product->company;
                        $product->images;
                    }
                }
            endforeach;
            return response()->json([
                "success"  => true,
                "subcategories" => $subcategories,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
    public function test(){
        $categories=Category::all();
        return view('test')->with('categories',$categories);
    }


    public function store(Request  $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:100',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $subcategory= new Subcategory;
            $subcategory->name =$request->name;
            $subcategory->bn_name =$request->bn_name;

            if(is_null($request->description)){
                $subcategory->description ="N/A";
            }else{
                $subcategory->description =$request->description;
            }
            if(is_null($request->bn_description)){
                $subcategory->bn_description ="N/A";
            }else{
                $subcategory->bn_description =$request->bn_description;
            }
            $subcategory->category_id =$request->category_id;
            if(is_null($request->image)){
                $subcategory->image="default.png";
            }else if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('/subcategory',$imageName,'public');
                $subcategory->image=$imageName;
            }

            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Subcategory::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $subcategory->slug =$slug;

            $subcategory->save();

            return response()->json([
                "success"  => true,
                "message" => "New Subcategory created!",
                "subcategory" => $subcategory,
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
            $subcategory = Subcategory::find($request->id);
            if(is_null($subcategory))
            return response()->json([
                "success"  => false,
                "message" => "No Subcategory Found!",

            ]);
            $category= $subcategory->category;
            $products =$subcategory->products;
            if(!is_null($products))
                {
                    foreach ($products as $product) {
                        $product->unit;
                        $product->company;
                        $product->images;
                    }
                }
            return response()->json([
                "success"  => true,
                "subcategory" => $subcategory,
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
            'image' => 'nullable|file|image|max:100',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $subcategory = Subcategory::find($request->id);
        $slug_change=0;
        if($subcategory->name!=$request->name){
            $slug_change=1;
        }
        $subcategory->name =$request->name;
        if(request()->has('bn_name'))
            $subcategory->bn_name =$request->bn_name;
        if(request()->has('description'))
            $subcategory->description =$request->description;

        if(is_null($request->bn_description)){
            $subcategory->bn_description ="N/A";
        }else{
            $subcategory->bn_description =$request->bn_description;
        }

        if(request()->hasFile('image')){
            if(!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg"){
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('/subcategory',$imageName,'public');
            $subcategory->image=$imageName;
        }
        $subcategory->category_id =$request->category_id;

        if($slug_change==1){
            $slug = Str::slug(str_replace( ' ', '-', $request->name));
            $i = 0;
            while(Subcategory::whereSlug($slug)->exists())
            {
                $i++;
                $slug = $slug ."-". $i;
            }
            $subcategory->slug =$slug;
        }
        $subcategory->save();

        return response()->json([
            "success"  => true,
            "message" => "Subcategory has been updated!",
            "subcategory" => $subcategory
        ]);
    }


    public function destroy(Request $request)
    {
        try{
            $subcategory = Subcategory::find($request->id);
            if(is_null($subcategory)){
                return response()->json([
                    "success"  => false,
                    "message" => "No Subcategory Found!",
                    ]);
            }
            if (!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
            }
            $subcategory->delete();
            return response()->json([
                "success"  => true,
                "message" => "Subcategory has been deleted!",
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        try{
            $categories = Category::all();      
            return response()->json([
                "sucess"  => true,
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
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'image' => 'sometimes|file|image|max:3000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $category= new Category;
            $category->name =$request->name;
            $category->bn_name =$request->bn_name;
            $category->description =$request->description;
            $category->bn_description =$request->bn_description;
            if(is_null($request->image)){
                $category->image="default.jpg";
            }else if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path('storage/category'), $imageName);
                $category->image=$imageName;
            }
            $category->save();

            return response()->json([
                "sucess"  => true,
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
                "sucess"  => false,
                "message" => "No Category Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
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
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'image' => 'sometimes|file|image|max:3000',   
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $category = Category::find($request->id);
        $category->name =$request->name;
        $category->bn_name =$request->bn_name;
        $category->description =$request->description;
        $category->bn_description =$request->bn_description;
        if(request()->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('storage/category'), $imageName);
            $category->image=$imageName;
        }
        $category->save();

        return response()->json([
            "sucess"  => true,
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
                "sucess"  => false,
                "message" => "No Category Found!",
                
            ]);
            if (!is_null($category->image) && $category->image !="default.png") {
                File::delete(public_path('/storage/category/'.$category->image));
            }
            $category->delete();
            return response()->json([
                "sucess"  => true,
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

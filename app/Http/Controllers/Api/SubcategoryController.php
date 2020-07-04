<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function index()
    {
        try{
            $subcategories = Subcategory::all();   
            foreach($subcategories as $subcategory ):
                $subcategory->category;
            endforeach;   
            return response()->json([
                "sucess"  => true,
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

    public function store(Request  $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'image' => 'sometimes|file|image|max:3000',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $subcategory= new Subcategory;
            $subcategory->name =$request->name;
            $subcategory->bn_name =$request->bn_name;
            $subcategory->description =$request->description;
            $subcategory->bn_description =$request->bn_description;
            $subcategory->category_id =$request->category_id;
            if(is_null($request->image)){
                $subcategory->image="subcategory/default.jpg";
            }
            $subcategory->save();

            return response()->json([
                "sucess"  => true,
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
                "sucess"  => false,
                "message" => "No Subcategory Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
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
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'bn_description' => 'sometimes|string',
            'image' => 'sometimes|file|image|max:3000',
            'category_id' => 'required',   
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $subcategory = Subcategory::find($request->id);
        $subcategory->name =$request->name;
        $subcategory->bn_name =$request->bn_name;
        $subcategory->description =$request->description;
        $subcategory->bn_description =$request->bn_description;
        $subcategory->category_id =$request->category_id;
        $subcategory->save();

        return response()->json([
            "sucess"  => true,
            "message" => "Subcategory has been updated!",
            "subcategory" => $subcategory
        ]);
    }

    
    public function destroy(Request  $request)
    {
        try{
            $subcategory = Subcategory::find($request->id);
            $subcategory->delete();
            return response()->json([
                "sucess"  => true,
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

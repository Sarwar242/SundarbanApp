<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Storage;

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
    public function test(){
        $categories=Category::all();
        return view('test')->with('categories',$categories);
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
                $subcategory->image="default.png";
            }else if(request()->hasFile('image')){
                // $file = $request->file('image');
            //    $extention=$file->getClientOriginalExtension();
                //dd( $file->getClientMimeType() );
                // $image=time().'.'.$extention;
                // file_put_contents('storage/subcategory/'.$image, base64_decode($request->image));

                $imageName = time().'.'.$request->image->extension();  
   
                $request->image->move(public_path('storage/subcategory'), $imageName);
                $subcategory->image=$imageName;
                // return response()->json([
                //     $request->image,
                //     "hasfile"
                //     ]);
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
            if(is_null($subcategory)){
                return response()->json([
                    "sucess"  => false,
                    "message" => "No Subcategory Found!",
                    ]);
            }
            if (!is_null($subcategory->image) && $subcategory->image !="default.png") {
                //dd(public_path('storage/subcategory/').$subcategory->image);
                File::delete(public_path('/storage/subcategory/'.$subcategory->image));

            }
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

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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

    
    public function create(){
        return view('backend.subcategory.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:3000',
            'category_id' => 'required',
        ]);
        
        try{
            $subcategory= new Subcategory;
            $subcategory->name =$request->name;
            $subcategory->bn_name =$request->bn_name;
            $subcategory->description =$request->description;
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
                $request->image->move(public_path('storage/subcategory'), $imageName);
                $subcategory->image=$imageName;
            }
         
            $subcategory->save();

            session()->flash('success', 'New Subcategory Added!!');
            return redirect()->route('admin.subcategory.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.subcategory.create');
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

   
    public function edit($id){
        $subcategory= Subcategory::find($id);
        return view('backend.subcategory.edit')->with('subcategory',$subcategory);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:3000',
            'category_id' => 'required',
        ]);


        $subcategory = Subcategory::find($id);
        $subcategory->name =$request->name;
        $subcategory->bn_name =$request->bn_name;
        $subcategory->description =$request->description;
        
        if(is_null($request->bn_description)){
            $subcategory->bn_description ="N/A";
        }else{
            $subcategory->bn_description =$request->bn_description;
        }
        
        if(request()->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('storage/subcategory'), $imageName);
            $subcategory->image=$imageName;
        }
        $subcategory->category_id =$request->category_id;
        $subcategory->save();

        session()->flash('success', 'Subcategory has been updated!!');
        return redirect()->route('admin.subcategory.update',$subcategory->id);
    }

    
    public function destroy($id)
    {
        try{
            $subcategory = Subcategory::find($id);
            if(is_null($subcategory)){
                session()->flash('failed', 'No Subcategory found !!!');
                return redirect()->route('admin.dashboard');
            }
            if (!is_null($subcategory->image) && $subcategory->image !="default.png") {
                File::delete(public_path('/storage/subcategory/'.$subcategory->image));

            }
            $subcategory->delete();
            session()->flash('success', 'A Subcategory has been Deleted!!');
            return redirect()->route('admin.dashboard');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }
}

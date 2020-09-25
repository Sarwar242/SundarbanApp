<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Auth;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('backend.subcategory.index');
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


            $subcategory->admin_id=Auth::guard('admin')->user()->id; 
         
            $subcategory->save();

            session()->flash('success', 'New Subcategory Added!!');
            return view('backend.subcategory.add')->with('subcategory', $subcategory->id);
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
            'description' => 'required|string',
            'bn_description' => 'required|string',
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
            if(!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg"){
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
                //dd(unlink(public_path('/storage/subcategory/'.$subcategory->image)));
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->storeAs('/subcategory',$imageName,'public');
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
            if (!is_null($subcategory->image) && $subcategory->image !="default.png" &&  $subcategory->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('subcategory/'.$subcategory->image);
                if($exists)
                    Storage::disk('public')->delete('subcategory/'.$subcategory->image);
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

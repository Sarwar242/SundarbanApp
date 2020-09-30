<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Auth;
class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // $slug=Category::slugComplete();
        // dd($slug);
        return view('backend.category.index');
    }

    public function create(){
        return view('backend.category.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:3000',
        ]);
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
            $category->admin_id=Auth::guard('admin')->user()->id; 
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

            session()->flash('success', 'New Category Added!!');
            return view('backend.category.add')->with('category',$category->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.category.create');
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

    public function edit($id){
        $category= Category::find($id);
        return view('backend.category.edit')->with('category',$category);
    }


   
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:3000',
        ]);
        $category = Category::find($request->id);
        if($category->name!=$request->name){
            $slug_change=1;
        }
        $category->name =$request->name;
        $category->bn_name =$request->bn_name;
        $category->description =$request->description;
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

        session()->flash('success', 'Category has been updated!!');
        return redirect()->route('admin.category.update',$category->id);
    }

    
    public function destroy($id)
    {
        try{
            $category = Category::find($id);
            if(is_null($category)){
            session()->flash('failed', 'No category found !!!');
            return redirect()->route('admin.dashboard');
        }
            if (!is_null($category->image) && $category->image !="default.png" &&  $category->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('category/'.$category->image);
                if($exists)
                   Storage::disk('public')->delete('category/'.$category->image);
            }
            $category->delete();
            session()->flash('success', 'A Category has been Deleted!!');
            return view('backend.category.index');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }
}

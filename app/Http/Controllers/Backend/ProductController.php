<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // $slug=Product::slugComplete();
        // dd($slug);
        return view('backend.product.index');
    }

    public function show($slug){
        $product = Product::where('slug', '=', $slug)->first();
        return view('backend.product.single')->with('product', $product);
    }

    public function create(){
        return view('backend.product.add');
    }

    public function store(Request  $request)
    {
        $this->validate($request,[
            'code'=>'required',
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
       
        try{
            $product= new Product;
            $product->code =$request->code;
            $product->name =$request->name;
            $product->bn_name =$request->bn_name;
            $product->description =$request->description;
            $product->bn_description =$request->bn_description;
            $product->price =$request->price;
            $product->admin_id=Auth::guard('admin')->user()->id; 
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
                    // dd($file) ;
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
                            ['message'=> ' '.$e.' '];
                    }
                endforeach;
            endif;

            session()->flash('success', 'New product Added!!');
            return view('backend.product.add')->with('product',$product->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.product.create');
        }
    }


    public function edit($id){
        $product=Product::find($id);
        return view('backend.product.edit')->with('product',$product);
    }


   
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'code'=>'required',
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
       
        $product = Product::find($id);
        $product->code =$request->code;
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

        session()->flash('success', 'The Product has been updated!!');
            return redirect()->route('admin.product.update',$product->id);
    }

    
    public function destroy($id)
    {
        try{
            $product = Product::find($id);
            if(is_null($product)){
                session()->flash('failed', 'No Product found !!!');
                return redirect()->route('admin.dashboard');
            }
        
            if (!empty($product->images)):
                $i=0;
                
                foreach ($product->images as $img):
                 
                   Storage::disk('public')->delete('product/'.$img->image);
                endforeach;

                
            endif;
            $product->delete();
            session()->flash('success', 'A Product has been Deleted!!');
            return redirect()->route('admin.products');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.products');
        }
    }

    public function deleteImage($id)
    {
        $productimagetbl = ProductImage::find($id);
        $product=$productimagetbl->product->slug;
        if(is_null($productimagetbl))
            return back();
        Storage::disk('public')->delete('product/'.$productimagetbl->image);
        $productimagetbl->delete();

        return redirect()->route('admin.product.show', $product);;

    }

    public function uploadImage(Request $request, $id)
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
                $imagetbl->product_id =$id;
                $imagetbl->priority = $i;
                $imagetbl->save();   

            }catch(Exception $e){
                    ['message'=> ' '.$e.' '];
            }
            endforeach;
            return back();

        else:
            return back();
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

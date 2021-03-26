<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Company;
use App\Models\Product;
use App\Models\Union;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;

class UnionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('backend.union.index');
    }



    public function create(){
        return view('backend.union.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'upazilla_id' => 'required',
        ]);

        try{
            $union= new Union;
            $union->name =$request->name;
            $union->bn_name =$request->bn_name;
            $union->longitude =$request->longitude;
            $union->latitude =$request->latitude;
            $union->upazilla_id =$request->upazilla_id;
            $union->admin_id=Auth::guard('admin')->user()->id;
            $union->save();

            session()->flash('success', 'A Union has been Added!!');
            return view('backend.union.add')->with('union', $union->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.union.create');
        }
    }

    public function show($id)
    {
        try{
            $union = Union::find($id);
            // $companies = $division->companies;
            // $categories = $companies;
            $categories=Category::join( 'companies', 'companies.category_id', '=', 'categories.id' )
                                    ->where('companies.union_id','=',$id)
                                    ->distinct()
                                    ->get(['categories.*']);
                                    // dd($categories);
            if(is_null($union))
                return back();

            return view('backend.union.details',compact(['union','categories']));
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function edit($id){
        $union=Union::find($id);
        return view('backend.union.edit')->with('union',$union);
    }


    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'upazilla_id' => 'required',
        ]);

        try{
            $union = Union::find($request->id);
            $union->name =$request->name;
            $union->bn_name =$request->bn_name;
            $union->longitude =$request->longitude;
            $union->latitude =$request->latitude;
            $union->upazilla_id =$request->upazilla_id;
            $union->save();

            session()->flash('success', 'The Union has been Updated!!');
            return redirect()->route('admin.union.update',$union->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.union.update',$union->id);
        }
    }


    public function destroy($id)
    {
        try{
            $union = Union::find($id);
            if(is_null($union)){
                session()->flash('failed', 'No Union found');
                return redirect()->route('admin.unions');
            }
            $union->delete();
            session()->flash('success', 'The Union has been Deleted!!');
            return redirect()->route('admin.unions');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.unions');
        }
    }


    public function categoryCompanies($category, $location){
        $companies=Company::where('union_id',$location)
                ->where('category_id',$category )->get();
            $data['location']= Union::find($location)->name;
            $data['category']= Category::find($category)->name;
            $data['subcategory']='';
        return view('backend.category.companies', compact(['companies','data']));
    }

    public function subcategoryCompanies($subcategory, $location){
        $companies=Company::where('union_id',$location)
                ->where('subcategory_id',$subcategory )->get();
            $data['location']= Union::find($location)->name;
            $data['subcategory']= Subcategory::find($subcategory)->name;
            $data['category']=Subcategory::find($subcategory)->category->name;
        // dd($companies);
        return view('backend.category.companies', compact(['companies','data']));
    }

    public function categoryProducts($category, $location){
            $products=Product::where('category_id',$category )->get();
            $data['location']= Union::find($location)->name;
            $data['category']= Category::find($category)->name;
            $data['subcategory']='';
        // dd($companies);
            return view('backend.category.products', compact(['products','data']));
    }

    public function subcategoryProducts($subcategory, $location){
            $products=Product::where('subcategory_id',$subcategory )->get();
            $data['location']= Union::find($location)->name;
            $data['subcategory']= Subcategory::find($subcategory)->name;
            $data['category']=Subcategory::find($subcategory)->category->name;
            return view('backend.subcategory.products', compact(['products','data']));
    }
}

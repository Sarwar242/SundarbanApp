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
use Illuminate\Support\Facades\Validator;
use Auth;

class UpazillaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('backend.upazilla.index');
    }



    public function create(){
        return view('backend.upazilla.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'district_id' => 'required',
        ]);

        try{
            $upazilla= new Upazilla;
            $upazilla->name =$request->name;
            $upazilla->bn_name =$request->bn_name;
            $upazilla->longitude =$request->longitude;
            $upazilla->latitude =$request->latitude;
            $upazilla->district_id =$request->district_id;
            $upazilla->admin_id=Auth::guard('admin')->user()->id;
            $upazilla->save();

            session()->flash('success', 'A Upazilla has been Added!!');
            return view('backend.upazilla.add')->with('upazilla',$upazilla->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.upazilla.create');
        }
    }

    public function show($id)
    {
        try{
            $upazilla = Upazilla::find($id);
            // $companies = $division->companies;
            // $categories = $companies;
            $categories=Category::join('companies', 'companies.category_id', '=', 'categories.id' )
                                    ->where('companies.upazilla_id','=',$id)
                                    ->distinct()
                                    ->get(['categories.*']);
                                    // dd($categories);
            if(is_null($upazilla))
                return back();

            return view('backend.upazilla.details',compact(['upazilla','categories']));
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function edit($id){
        $upazilla=Upazilla::find($id);
        return view('backend.upazilla.edit')->with('upazilla',$upazilla);
    }



    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'district_id' => 'required',
        ]);

        try{
            $upazilla=Upazilla::find($id);
            $upazilla->name =$request->name;
            $upazilla->bn_name =$request->bn_name;
            $upazilla->longitude =$request->longitude;
            $upazilla->latitude =$request->latitude;
            $upazilla->district_id =$request->district_id;
            $upazilla->save();

            session()->flash('success', 'The Upazilla has been Updated!!');
            return redirect()->route('admin.upazilla.update',$upazilla->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.upazilla.update',$upazilla->id);
        }
    }


    public function destroy($id)
    {
        try{
            $upazilla = Upazilla::find($id);
            if(is_null($upazilla)){
                session()->flash('failed', 'No upazilla found');
                return redirect()->route('admin.upazillas');
            }
            $upazilla->delete();
            session()->flash('success', 'The Upazilla has been Deleted!!');
            return redirect()->route('admin.upazillas');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.upazillas');
        }
    }

    public function categoryCompanies($category, $location){
        $companies=Company::where('upazilla_id',$location)
                ->where('category_id',$category )->get();
            $data['location']= Upazilla::find($location)->name;
            $data['category']= Category::find($category)->name;
            $data['subcategory']='';
        return view('backend.category.companies', compact(['companies','data']));
    }

    public function subcategoryCompanies($subcategory, $location){
        $companies=Company::where('upazilla_id',$location)
                ->where('subcategory_id',$subcategory )->get();
            $data['location']= Upazilla::find($location)->name;
            $data['subcategory']= Subcategory::find($subcategory)->name;
            $data['category']=Subcategory::find($subcategory)->category->name;
        // dd($companies);
        return view('backend.category.companies', compact(['companies','data']));
    }


    public function categoryProducts($category, $location){
            $products=Product::where('category_id',$category )->get();
            $data['location']= Upazilla::find($location)->name;
            $data['category']= Category::find($category)->name;
            $data['subcategory']='';
        // dd($companies);
            return view('backend.category.products', compact(['products','data']));
    }

    public function subcategoryProducts($subcategory, $location){
            $products=Product::where('subcategory_id',$subcategory )->get();
            $data['location']= Upazilla::find($location)->name;
            $data['subcategory']= Subcategory::find($subcategory)->name;
            $data['category']=Subcategory::find($subcategory)->category->name;
            return view('backend.subcategory.products', compact(['products','data']));
    }
}

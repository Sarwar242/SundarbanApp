<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Auth;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('backend.district.index');
    }



    public function create(){
        return view('backend.district.add');
    }


    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'website' => 'nullable|string',
            'division_id' => 'required',
        ]);
        try{
            $district= new District;
            $district->name =$request->name;
            $district->bn_name =$request->bn_name;
            $district->longitude =$request->longitude;
            $district->latitude =$request->latitude;
            $district->website =$request->website;
            $district->division_id =$request->division_id;

            $district->admin_id=Auth::guard('admin')->user()->id;

            $district->save();

            session()->flash('success', 'A District has been Added!!');
            return view('backend.district.add')->with('district', $district->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.district.create');
        }
    }

    public function show($id)
    {
        try{
            $district = District::find($id);
            // $companies = $division->companies;
            // $categories = $companies;
            $categories=Category::join( 'companies', 'companies.category_id', '=', 'categories.id' )
                                    ->where('companies.district_id','=',$id)
                                    ->distinct()
                                    ->get(['categories.*']);
                                    // dd($categories);
            if(is_null($district))
                return back();

            return view('backend.district.details',compact(['district','categories']));
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }


    public function edit($id){
        $district= District::find($id);
        return view('backend.district.edit')->with('district',$district);
    }


    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'website' => 'nullable|string',
            'division_id' => 'required',
        ]);
        try{
            $district=District::find($id);;
            $district->name =$request->name;
            $district->bn_name =$request->bn_name;
            $district->longitude =$request->longitude;
            $district->latitude =$request->latitude;
            $district->website =$request->website;
            $district->division_id =$request->division_id;

            $district->save();

            session()->flash('success', 'The District has been Updated!!');
            return redirect()->route('admin.district.update',$district->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.district.update',$district->id);
        }
    }


    public function destroy($id)
    {
        try{
            $district = District::find($id);
            if(is_null($district)){
                session()->flash('failed', 'No district found');
                return redirect()->route('admin.districts');
            }

            $district->delete();
            session()->flash('success', 'The District has been Deleted!!');
            return redirect()->route('admin.districts');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.districts');
        }
    }

    public function categoryCompanies($category, $location){
        $companies=Company::where('district_id',$location)
                ->where('category_id',$category )->get();
            $data['location']= District::find($location)?District::find($location)->name:'Location';
            $data['category']= Category::find($category)?Category::find($category)->name:'Category';
            $data['subcategory']='';
        return view('backend.category.companies', compact(['companies','data']));
    }

    public function subcategoryCompanies($subcategory, $location){
        $companies=Company::where('district_id',$location)
                ->where('subcategory_id',$subcategory )->get();
            $data['location']= District::find($location)?District::find($location)->name:'Location';
            $data['subcategory']= Subcategory::find($subcategory)?Subcategory::find($subcategory)->name:'Subcategory';
            $data['category']=Subcategory::find($subcategory)?Subcategory::find($subcategory)->category->name:'Category';
        // dd($companies);
        return view('backend.category.companies', compact(['companies','data']));
    }


    public function categoryProducts($category, $location){
            $products=Product::where('category_id',$category )->get();
            $data['location']= District::find($location)->name;
            $data['category']= Category::find($category)->name;
            $data['subcategory']='';
        // dd($companies);
            return view('backend.category.products', compact(['products','data']));
    }

    public function subcategoryProducts($subcategory, $location){
            $products=Product::where('subcategory_id',$subcategory )->get();
            $data['location']= District::find($location)->name;
            $data['subcategory']= Subcategory::find($subcategory)->name;
            $data['category']=Subcategory::find($subcategory)->category->name;
            return view('backend.subcategory.products', compact(['products','data']));
    }
}

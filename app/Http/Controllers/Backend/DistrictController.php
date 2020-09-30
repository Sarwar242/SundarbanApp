<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
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
            if(is_null($district))
            return response()->json([
                "sucess"  => false,
                "message" => "No District Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
                "district" => $district,
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
}

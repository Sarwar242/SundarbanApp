<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
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
            $upazilla = Upazilla::find($request->id);
            if(is_null($upazilla))
            return response()->json([
                "sucess"  => false,
                "message" => "No upazilla Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
                "upazilla" => $upazilla,
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
}

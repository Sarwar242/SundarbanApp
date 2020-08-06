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
            return redirect()->route('admin.upazilla.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.upazilla.create');
        }
    }

    public function show(Request  $request)
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



   
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'district_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $upazilla=Upazilla::find($request->id);
            $upazilla->name =$request->name;
            $upazilla->bn_name =$request->bn_name;
            $upazilla->longitude =$request->longitude;
            $upazilla->latitude =$request->latitude;
            $upazilla->district_id =$request->district_id;
            $upazilla->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Upazilla has been updated!",
                "upazilla" => $upazilla,
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    
    public function destroy(Request  $request)
    {
        try{
            $upazilla = Upazilla::find($request->id);
            if(is_null($upazilla))
            return response()->json([
                "sucess"  => false,
                "message" => "No Upazilla Found!",    
            ]);    
            $upazilla->delete();
            return response()->json([
                "sucess"  => true,
                "message" => "Upazilla has been deleted!",
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

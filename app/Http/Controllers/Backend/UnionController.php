<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Union;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class UnionController extends Controller
{
    public function index()
    {
        try{
            $unions = Union::all();
            return response()->json([
                "sucess"  => true,
                "unions" => $unions,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
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
            $union->save();

            session()->flash('success', 'A Union has been Added!!');
            return redirect()->route('admin.union.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.union.create');
        }
    }

    public function show(Request  $request)
    {
        try{
            $union = Union::find($request->id);
            if(is_null($union))
            return response()->json([
                "sucess"  => false,
                "message" => "No union Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
                "union" => $union,
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
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'longitude' => 'sometimes|string',
            'latitude' => 'sometimes|string',
            'upazilla_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $union = Union::find($request->id);
            $union->name =$request->name;
            $union->bn_name =$request->bn_name;
            $union->longitude =$request->longitude;
            $union->latitude =$request->latitude;
            $union->upazilla_id =$request->upazilla_id;
            $union->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Union has been updated!",
                "union" => $union,
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
            $union = Union::find($request->id);
            if(is_null($union))
                return response()->json([
                    "sucess"  => false,
                    "message" => "No union Found!",    
                ]);    
            $union->delete();
            return response()->json([
                "sucess"  => true,
                "message" => "Union has been deleted!",
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use Illuminate\Support\Facades\Validator;


class UpazillaController extends Controller
{
    public function index()
    {
        try{
            $upazillas = Upazilla::all();
            return response()->json([
                "success"  => true,
                "upazillas" => $upazillas,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function store(Request  $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'longitude' => 'sometimes|string',
            'latitude' => 'sometimes|string',
            'district_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $upazilla= new Upazilla;
            $upazilla->name =$request->name;
            $upazilla->bn_name =$request->bn_name;
            $upazilla->longitude =$request->longitude;
            $upazilla->latitude =$request->latitude;
            $upazilla->district_id =$request->district_id;
            $upazilla->save();

            return response()->json([
                "success"  => true,
                "message" => "Upazilla has been added!",
                "upazilla" => $upazilla,
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function show(Request  $request)
    {
        try{
            $upazilla = Upazilla::find($request->id);
            if(is_null($upazilla))
            return response()->json([
                "success"  => false,
                "message" => "No upazilla Found!",
                
            ]);
            
            return response()->json([
                "success"  => true,
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
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'longitude' => 'sometimes|string',
            'latitude' => 'sometimes|string',
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
                "success"  => true,
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
                "success"  => false,
                "message" => "No Upazilla Found!",    
            ]);    
            $upazilla->delete();
            return response()->json([
                "success"  => true,
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class DistrictController extends Controller
{
    public function index()
    {
        try{
            $districts = District::orderBy('name', 'ASC')->get();
            return response()->json([
                "success"  => true,
                "districts" => $districts,
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
            'website' => 'sometimes|string',
            'division_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $district= new District;
            $district->name =$request->name;
            $district->bn_name =$request->bn_name;
            $district->longitude =$request->longitude;
            $district->latitude =$request->latitude;
            $district->website =$request->website;
            $district->division_id =$request->division_id;

            $district->save();

            return response()->json([
                "success"  => true,
                "message" => "District has been added!",
                "district" => $district,
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
            $district = District::find($request->id);
            if(is_null($district))
            return response()->json([
                "success"  => false,
                "message" => "No District Found!",

            ]);

            return response()->json([
                "success"  => true,
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




    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'sometimes|string',
            'bn_name' => 'sometimes|string',
            'longitude' => 'sometimes|string',
            'latitude' => 'sometimes|string',
            'website' => 'sometimes|string',
            'division_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $district=District::find($request->id);;
            $district->name =$request->name;
            $district->bn_name =$request->bn_name;
            $district->longitude =$request->longitude;
            $district->latitude =$request->latitude;
            $district->website =$request->website;
            $district->division_id =$request->division_id;

            $district->save();

            return response()->json([
                "success"  => true,
                "message" => "District has been updated!",
                "district" => $district,
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
            $district = District::find($request->id);
            if(is_null($district))
            return response()->json([
                "success"  => false,
                "message" => "No District Found!",
            ]);
            $district->delete();
            return response()->json([
                "success"  => true,
                "message" => "District has been deleted!",
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

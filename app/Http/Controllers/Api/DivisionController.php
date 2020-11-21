<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class DivisionController extends Controller
{
    public function index()
    {
        try{
            $divisions = Division::orderBy('name', 'ASC')->get();
            return response()->json([
                "success"  => true,
                "divisions" => $divisions,
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
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $division= new Division;
            $division->name =$request->name;
            $division->bn_name =$request->bn_name;
            $division->longitude =$request->longitude;
            $division->latitude =$request->latitude;

            $division->save();

            return response()->json([
                "success"  => true,
                "message" => "Division has been added!",
                "division" => $division,
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
            $division = Division::find($request->id);
            if(is_null($division))
            return response()->json([
                "success"  => false,
                "message" => "No Division Found!",

            ]);

            return response()->json([
                "success"  => true,
                "division" => $division,
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
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $division = Division::find($request->id);
            $division->name =$request->name;
            $division->bn_name =$request->bn_name;
            $division->longitude =$request->longitude;
            $division->latitude =$request->latitude;
            $division->save();

            return response()->json([
                "success"  => true,
                "message" => "Division has been updated!",
                "division" => $division
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }


    public function destroy(Request  $request)
    {
        try{
            $division = Division::find($request->id);
            if(is_null($division))
            return response()->json([
                "success"  => false,
                "message" => "No Division Found!",
            ]);
            $division->delete();
            return response()->json([
                "success"  => true,
                "message" => "Division has been deleted!",
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

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
class UnitController extends Controller
{
    public function index()
    {
        try{
            $units = Unit::all();
            return response()->json([
                "sucess"  => true,
                "units" => $units,
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
        return view('backend.unit.add');
    }


    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
        ]);
        
        try{
            $unit= new Unit;
            $unit->name =$request->name;
            $unit->bn_name =$request->bn_name;
            $unit->save();

            session()->flash('success', 'A Unit has been Added!!');
            return redirect()->route('admin.unit.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.unit.create');
        }
    }

    public function show(Request  $request)
    {
        try{
            $unit = Unit::find($request->id);
            if(is_null($unit))
            return response()->json([
                "sucess"  => false,
                "message" => "No Unit Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
                "unit" => $unit,
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
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $unit = Unit::find($request->id);
            $unit->name =$request->name;
            $unit->bn_name =$request->bn_name;
            $unit->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Unit has been updated!",
                "unit" => $unit
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
            $unit = Unit::find($request->id);
            if(is_null($unit))
            return response()->json([
                "sucess"  => false,
                "message" => "No Unit Found!",    
            ]);    
            $unit->delete();
            return response()->json([
                "sucess"  => true,
                "message" => "Unit has been deleted!",
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

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Auth;
class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        return view('backend.unit.index');
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
            $unit->admin_id=Auth::guard('admin')->user()->id; 
            $unit->save();

            session()->flash('success', 'A Unit has been Added!!');
            return view('backend.unit.add')->with('unit', $unit->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.unit.create');
        }
    }

    public function show($id)
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



    public function edit($id){
        $unit= Unit::find($id);
        return view('backend.unit.edit')->with('unit',$unit);
    }
   
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'bn_name' => 'nullable|string',
        ]);
        
        try{
            $unit = Unit::find($id);
            $unit->name =$request->name;
            $unit->bn_name =$request->bn_name;
            $unit->save();

            session()->flash('success', 'The Unit has been Updated!!');
            return redirect()->route('admin.unit.update',$unit->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.unit.update',$unit->id);
        }
    }

    
    public function destroy($id)
    {
        try{
            $unit = Unit::find($id);
            if(is_null($unit)){
                session()->flash('failed', 'No Unit found');
                return redirect()->route('admin.units');
            }
            $unit->delete();
            session()->flash('success', 'The Unit has been Deleted!!');
            return redirect()->route('admin.units');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.units');
        }
    }
}

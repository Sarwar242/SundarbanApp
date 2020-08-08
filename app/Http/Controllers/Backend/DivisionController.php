<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class DivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        return view('backend.division.index');
    }


        
    public function create(){
        return view('backend.division.add');
    }

    public function store(Request  $request)
    {

        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);
     
        try{
            $division= new Division;
            $division->name =$request->name;
            $division->bn_name =$request->bn_name;
            $division->longitude =$request->longitude;
            $division->latitude =$request->latitude;
  
            $division->save();

            session()->flash('success', 'A Division has been Added!!');
            return redirect()->route('admin.division.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.division.create');
        }
    }

    public function show(Request  $request)
    {
        try{
            $division = Division::find($request->id);
            if(is_null($division))
            return response()->json([
                "sucess"  => false,
                "message" => "No Division Found!",
                
            ]);
            
            return response()->json([
                "sucess"  => true,
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


    public function edit($id){
        $division= Division::find($id);
        return view('backend.division.edit')->with('division',$division);
    }


   
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'sometimes|string',
            'bn_name' => 'nullable|string',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
        ]);
     
        try{
            $division = Division::find($id);
            $division->name =$request->name;
            $division->bn_name =$request->bn_name;
            $division->longitude =$request->longitude;
            $division->latitude =$request->latitude;
            $division->save();

            session()->flash('success', 'The Division has been Updated!!');
            return redirect()->route('admin.division.update',$division->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.division.update',$division->id);
        }
    }

    
    public function destroy($id)
    {
        try{
            $division = Division::find($id);
            if(is_null($division)){
                session()->flash('failed', 'No division found');
                return redirect()->route('admin.divisions');
            }
            
            $division->delete();
            session()->flash('success', 'The Division has been Deleted!!');
            return redirect()->route('admin.divisions');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.divisions');
        }
    }
}

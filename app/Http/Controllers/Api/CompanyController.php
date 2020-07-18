<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    
    public function companies(Request $request)
    {
        $companies= Company::all();
        foreach($companies as $company):
            $company=$company->user;
        endforeach;

        return response()->json([
            'success'=>true,
            'companies'=>$companies
           ]);
    }

    public function profile(Request $request)
    {
        $company= Company::find($request->id);
        return response()->json([
            'success'=>true,
            'company'=>$company
           ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'name' => 'required|string',
            'bn_name' => 'sometimes|string',
            'owners_name' => 'sometimes|string',
            'owners_nid' => 'sometimes|string',
            'phone1' => 'sometimes|numeric|phone',
            'phone2' => 'sometimes|numeric|phone',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string',
            'street' => 'sometimes|string',
            'website' => 'sometimes|string',
            'business_type' => 'sometimes|string',
            'type' => 'sometimes|string',
            'zipcode' => 'sometimes|string',
            'union_id' => 'sometimes|string',
            'upazilla_id' => 'sometimes|string',
            'district_id' => 'sometimes|string',
            'division_id' => 'sometimes|string',
            'image' => 'sometimes|file|image|max:3000',   
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $company = Company::find($request->id);
            $company->name =$request->name;
            $company->bn_name =$request->bn_name;
            $company->owners_name =$request->owners_name;
            $company->owners_nid =$request->owners_nid;
            $company->phone1 =$request->phone1;
            $company->phone2 =$request->phone2;
            $company->description =$request->description;
            $company->location =$request->location;
            $company->street =$request->street;
            $company->website =$request->website;
            $company->business_type =$request->business_type;
            $company->type =$request->type;
            $company->zipcode =$request->zipcode;
            $company->union_id =$request->union_id;
            $company->upazilla_id =$request->upazilla_id;
            $company->district_id =$request->district_id;
            $company->division_id =$request->division_id;;
            
            if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path('storage/company'), $imageName);
                $company->image=$imageName;
            }
            $company->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Company profile has been updated!",
                "company" => $company
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }


    public function destroy(Request $request)
    {
        try{
            $company = Company::find($request->id);
            $id=$company->user_id;
            $user= User::find($id);
            $user->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Company Deleted!'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

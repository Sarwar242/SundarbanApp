<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
   
    public function customers(Request $request)
    {
        $customers= Customer::all();
        foreach($customers as $customer):
            $customer=$customer->user;
        endforeach;

        return response()->json([
            'success'=>true,
            'customers'=>$customers
           ]);
    }


    public function profile(Request $request)
    {
        $customer= Customer::find($request->id);
        return response()->json([
            'success'=>true,
            'customer'=>$customer
           ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'sometimes|date_format:d-m-Y|before:today',
            'hn' => 'sometimes|string',
            'nid' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'phone' => 'sometimes|numeric|phone',
            'street' => 'sometimes|string',
            'zipcode' => 'sometimes|string',
            'village' => 'sometimes|string',
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
            $customer = Customer::find($request->id);
            $customer->first_name =$request->first_name;
            $customer->last_name =$request->last_name;
            $customer->dob =$request->dob;
            $customer->hn =$request->hn;
            $customer->nid =$request->nid;
            $customer->gender =$request->gender;
            $customer->phone =$request->phone;
            $customer->street =$request->street;
            $customer->zipcode =$request->zipcode;
            $customer->village =$request->village;
            $customer->union_id =$request->union_id;
            $customer->upazilla_id =$request->upazilla_id;
            $customer->district_id =$request->district_id;
            $customer->division_id =$request->division_id;
            
            if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path('storage/customer'), $imageName);
                $customer->image=$imageName;
            }

            $customer->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Customer profile has been updated!",
                "customer" => $customer
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
            $customer = Customer::find($request->id);
            $id=$customer->user_id;
            $user= User::find($id);
            $user->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Customer Deleted!'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

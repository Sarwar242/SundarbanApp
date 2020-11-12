<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Follow;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function customers(Request $request)
    {
        $customers= Customer::all();
        foreach($customers as $customer):
            $user=$customer->user;
            $division = $customer->division;
            $district=$customer->district;
            $upazilla=$customer->upazilla;
            $union=$customer->union;
        endforeach;

        return response()->json([
            'success'=>true,
            'customers'=>$customers
           ]);
    }


    public function profile(Request $request)
    {
        $customer= Customer::find($request->id);
        if(is_null($customer)){
            return response()->json([
                'success'=>false,
                'message'=>'No customer found in database!'
               ]);
        }
        $division = $customer->division;
        $district=$customer->district;
        $upazilla=$customer->upazilla;
        $union=$customer->union;
        $user=User::find($customer->user_id);
        $following=$user->followings()->get()->count() ;
        return response()->json([
            'success'=>true,
            'customer'=>$customer,
            'following'=>$following
           ]);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'nullable|before:today',
            'hn' => 'nullable|string',
            'nid' => 'nullable|string',
            'gender' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'required|numeric|phone|unique:users,phone,'.$customer->user->id,
            'phone_hide' => 'nullable|boolean',
            'phone2' => 'nullable|numeric|phone',
            'street' => 'nullable|string',
            'bn_street' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'location' => 'nullable|string',
            'bn_location' => 'nullable|string',
            'about' => 'nullable|string',
            'bn_about' => 'nullable|string',
            'union_id' => 'nullable|string',
            'upazilla_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'division_id' => 'nullable|string',
            'password'=>'nullable|min:8|confirmed',
            'image' => 'nullable|file|image|max:3000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $customer->first_name =$request->first_name;
            $customer->last_name =$request->last_name;
            if(request()->has('email'))
                $customer->user->email =$request->email;
            $customer->user->phone =$request->phone;
            if(request()->has('phone_hide'))
                $customer->phone_hide =$request->phone_hide;
            if(request()->has('dob'))
                $customer->dob =$request->dob;
            if(request()->has('hn'))
                $customer->hn =$request->hn;
            if(request()->has('nid'))
                $customer->nid =$request->nid;
            if(request()->has('gender'))
                $customer->gender =$request->gender;
            if(request()->has('phone2'))
                $customer->phone =$request->phone2;
            if(request()->has('about'))
                $customer->about =$request->about;
            if(request()->has('bn_about'))
                $customer->bn_about =$request->bn_about;
            if(request()->has('street'))
                $customer->street =$request->street;
            if(request()->has('bn_street'))
                $customer->bn_street =$request->bn_street;
            if(request()->has('zipcode'))
                $customer->zipcode =$request->zipcode;
            if(request()->has('location'))
                $customer->location =$request->location;
            if(request()->has('bn_location'))
                $customer->bn_location =$request->bn_location;
            if(request()->has('union_id'))
                $customer->union_id =$request->union_id;
            if(request()->has('upazilla_id'))
                $customer->upazilla_id =$request->upazilla_id;
            if(request()->has('district_id'))
                $customer->district_id =$request->district_id;
            if(request()->has('division_id'))
                $customer->division_id =$request->division_id;

            if(request()->hasFile('image')){
                if(!is_null($customer->image) && $customer->image !="default.png" &&  $customer->image !="default.jpg"){
                    $exists = Storage::disk('public')->exists('customer/'.$customer->image);
                    if($exists)
                        Storage::disk('public')->delete('customer/'.$customer->image);
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->storeAs('/customer',$imageName,'public');
                $customer->image=$imageName;
            }

            $customer->user->save();
            $customer->save();
            return response()->json([
                "success"  => true,
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
            if(is_null($customer)){
                return response()->json([
                    'success'=>false,
                    'message'=> 'No Customer Found!',
                ]);
            }
            if (!is_null($customer->image) && $customer->image !="default.png" &&  $customer->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('customer/'.$customer->image);
                if($exists)
                   Storage::disk('public')->delete('customer/'.$customer->image);
            }
            $user_id=$customer->user_id;
            $user= User::find($user_id);
            if(!is_null($user)){
                $user->delete();
            }
            else{
                $customer->delete();
            }
            return response()->json([
                'success'=>true,
                'message'=>'Customer has been Deleted!'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

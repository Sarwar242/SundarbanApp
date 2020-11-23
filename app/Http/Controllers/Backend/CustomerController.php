<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('backend.customer.index');
    }

    public function profile($username){
        $customer = Customer::where('username', '=', $username)->first();
        // dd($company);
        return view('backend.customer.profile')->with('customer', $customer);
    }

    public function create()
    {
        return view('backend.customer.add');
    }

    public function edit($id){
        $customer= Customer::find($id);

        return view('backend.customer.edit')->with('customer',$customer);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'nullable|before:today',
            'hn' => 'nullable|string',
            'nid' => 'nullable|string',
            'gender' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'required|numeric|phone',
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
        try{
            $customer = Customer::find($id);
            $customer->first_name =$request->first_name;
            $customer->last_name =$request->last_name;
            $customer->user->email =$request->email;
            $customer->user->phone =$request->phone;
            if(request()->has('phone_hide'))
                $customer->phone_hide =$request->phone_hide;
            $customer->dob =$request->dob;
            $customer->hn =$request->hn;
            $customer->nid =$request->nid;
            $customer->gender =$request->gender;
            $customer->phone =$request->phone2;
            $customer->about =$request->about;
            $customer->bn_about =$request->bn_about;
            $customer->street =$request->street;
            $customer->bn_street =$request->bn_street;
            $customer->zipcode =$request->zipcode;
            $customer->location =$request->location;
            $customer->bn_location =$request->bn_location;
            $customer->union_id =$request->union_id;
            $customer->upazilla_id =$request->upazilla_id;
            $customer->district_id =$request->district_id;
            $customer->division_id =$request->division_id;

        //    dd($request);

            if(!is_null($request->password)){
                $encryptedPass= Hash::make($request->password);
                $customer->user->password =$encryptedPass;
            }

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

            session()->flash('success', 'The Customer has been Updated!!');
            return redirect()->route('admin.customer.update',$customer->id);

            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.customer.update',$customer->id);
            }
    }

    public function ban(Request $request){
        try{
            $customer=Customer::find($request->id);

            if(is_null($customer))
            return json_encode([
                "sucess"  => false,
                "message" => "No customer Found!",
            ]);
            if($customer->ban==1){
                $customer->ban = 0;
                $customer->save();

                return json_encode([
                    'success'=>true,
                    'message'=> "The customer has been unbaned!",
                   ]);
            }

            else{
                $customer->ban = 1;
                $customer->save();
                return json_encode([
                    'success'=>true,
                    'message'=> "The customer has been baned!",
                   ]);
            }

        }catch(Exception $e){
            return json_encode([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }

    public function destroy($id)
    {
        try{
            $customer = Customer::find($id);
            if(is_null($customer)){
                session()->flash('failed', 'No customer found !!!');
                return redirect()->route('admin.customers');
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

            session()->flash('success', 'A customer has been Deleted!!');
            return redirect()->route('admin.customers');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }

}

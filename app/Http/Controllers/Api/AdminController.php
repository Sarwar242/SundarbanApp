<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Passport\HasApiTokens;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Admin::class,
        ]]);
    }

    
    
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email'=>'email|required',
            'password' => 'required',
        ]);
       
        if(!$token = auth()->attempt($loginData)){
                return response()->json([
                    'success'=>false,
                    'message'=>'Invalid Credintials'
             ]);
            }
        
        $user=Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;
        

        return response()->json([
        'success'=>true,
        'access_token'=> $accessToken,
        'admin' =>auth()->user(),
        ]);    
    
    }

    public function hash(Request $request)
    {
        $encryptedPass= Hash::make($request->password);
        return response()->json([
            'success'=>true,
            'password'=>$request->password,
            'hash'=> $encryptedPass,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        $admin=Auth::guard('api')->user();
        return response()->json([
            'success'=>true,
            'admin'=> $admin,
           ]);
        
    }

    public function profile(Request $request)
    {
        $admin=Admin::find($request->id);
        return response()->json([
            'success'=>true,
            'admin'=> $admin,
           ]);
        
    }

    

    public function logout(Request $request){
        if(auth('api')->check()){
            auth('api')->user()->token()->revoke() ;
            return response()->json([
                'success'=>true,
                'message'=> 'Logout Success'
               ]);
        }
        else{
            return response()->json([
                'success'=>false,
                'message'=> 'invalid request!'
            ]);
        }
    }

     public function admins(Request $request)
     {
        $admins=Admin::all();
         
        return response()->json([
            'success'=>true,
            'admins'=>$admins
           ]);
     }
     

     public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'username' => 'sometimes|string',
            'type' => 'sometimes|string',
            'phone1' => 'sometimes|numeric|phone',
            'phone2' => 'sometimes|numeric|phone',
            'nid' => 'sometimes|string',
            'location' => 'sometimes|string',
            'street' => 'sometimes|string',
            'about' => 'sometimes|string',
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
            $admin = Admin::find($request->id);
            $admin->first_name =$request->first_name;
            $admin->last_name =$request->last_name;
            $admin->username =$request->username;
            $admin->phone1 =$request->phone1;
            $admin->phone2 =$request->phone2;
            $admin->nid =$request->nid;
            $admin->about =$request->about;
            $admin->location =$request->location;
            $admin->street =$request->street;
            $admin->type =$request->type;
            $admin->zipcode =$request->zipcode;
            $admin->union_id =$request->union_id;
            $admin->upazilla_id =$request->upazilla_id;
            $admin->district_id =$request->district_id;
            $admin->division_id =$request->division_id;;
            
            if(request()->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path('storage/admin'), $imageName);
                $admin->image=$imageName;
            }
            $admin->save();

            return response()->json([
                "sucess"  => true,
                "message" => "Admin profile has been updated!",
                "admin" => $admin
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
     
     public function users(Request $request)
     {
         $users=User::all();
         foreach($users as $user):
            if($user->is_company):
                $company=$user->company;
            else:
                $customer=$user->customer;
            endif;
        endforeach;
        return response()->json([
            'success'=>true,
            'users'=>$users
           ]);
     }

     public function change_password(Request $request){
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $user=Auth::guard('api')->user();
       //dd($userid);
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("success" => false, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), $user->password)) == false) {
                    $arr = array("success" => false, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), $user->password)) == true) {
                    $arr = array("success" => false, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    Admin::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("success" => true, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("success" => false, "message" => $msg, "data" => array());
            }
        }
        return response()->json($arr);
    }

}

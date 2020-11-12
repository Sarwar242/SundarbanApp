<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $loginData = $request->validate([
            'phone'=>'phone|required',
            'password' => 'required',
        ]);

        if(!auth()->attempt($loginData)){
                return response()->json([
                    'success'=>false,
                    'message'=>'Invalid Credintials'
             ]);
            }
        $user=Auth::user();
        if($user->is_company==1){
            $company=$user->company;
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'success'=>true,
                'access_token'=> $accessToken,
                'user' =>auth()->user(),
                ]);
        }else if($user->is_company==0){
            $customer = $user->customer;
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
            'success'=>true,
            'access_token'=> $accessToken,
            'user' =>auth()->user(),
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Invalid Credintials'
            ]);
        }
    }



    public function register(Request $request){

        $rules = [
            'phone'=>'phone|required|unique:users',
            'password' => 'required|min:8',
            'is_company' => 'required|boolean',
        ];
        $response = array('response' => '', 'success'=>false);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();

            return $response;
        }else{

            $encryptedPass= Hash::make($request->password);
            if($request->is_company==1){
                $validator2 = Validator::make($request->all(),[
                    'email'=>'email|nullable|unique:users',
                    'phone'=>'phone|required|unique:users',
                    'password' => 'required|min:8',
                    'is_company' => 'required|boolean',
                    'name' => 'required|string',
                ]);
                if ($validator2->fails()) {
                    return response()->json($validator2->errors(), 422);
                 }

                try {
                    $user = new User;
                    $user->email =$request->email;
                    $user->phone =$request->phone;
                    $user->password =$encryptedPass;
                    $user->is_company=$request->is_company;
                    $user->save();
                    $profile = new Company;
                    $profile->name=$request->name;
                    $profile->user_id=$user->id;
                    $profile->image="default.png";
                    $profile->user_id=$user->id;
                    $profile->off_day="Friday";
                    $profile->open="09:00:00";
                    $profile->close="21:00:00";
                    $slug = Str::slug(str_replace( ' ', '-', $request->name));
                    $i = 0;
                    while(Company::whereSlug($slug)->exists())
                    {
                        $i++;
                        $slug = $slug . $i;
                    }
                    $profile->slug = $slug;

                    $lastId = Company::latest('id')->first()->id;
                    $code =  100000000+$lastId+1;
                    $i = 0;
                    while(Company::whereCode($code)->exists())
                    {
                        $i++;
                        $code = $code + $i;
                    }
                    $profile->code = $code;
                    $profile->save();
                    $accessToken = $user->createToken('authToken')->accessToken;
                    return response()->json([
                        'success'=>true,
                        'user'=> $user,
                        'profile'=> $profile,
                        'access_token'=>$accessToken,
                   ]);
            }catch(Exception $e){
                return response()->json([
                    'success'=>false,
                    'message'=> ''.$e
                   ]);
            }
        }
        else if($request->is_company==0){

            $validator2 = Validator::make($request->all(),[
                'email'=>'email|nullable|unique:users',
                'password' => 'required|min:8',
                'is_company' => 'required|boolean',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);
            if ($validator2->fails()) {
                return response()->json($validator2->errors(), 422);
            }
            try{
                $user = new User;
                $user->email =$request->email;
                $user->phone =$request->phone;
                $user->password =$encryptedPass;
                $user->is_company=$request->is_company;
                $user->save();
                $profile = new Customer;
                $profile->first_name=$request->first_name;
                $profile->last_name=$request->last_name;
                $profile->image="default.png";
                $profile->user_id=$user->id;
                $username = Str::slug($request->first_name . "-" . $request->last_name);
                $i = 0;
                while(Customer::whereUsername($username)->exists())
                {
                    $i++;
                    $username = $username . $i;
                }
                $profile->username =$username;
                $profile->save();
                $accessToken = $user->createToken('authToken')->accessToken;
                return response()->json([
                    'success'=>true,
                    'user'=> $user,
                    'profile'=> $profile,
                    'access_token'=>$accessToken,
                   ]);
                }catch(Exception $e){
                    return response()->json([
                        'success'=>false,
                        'message'=> ''.$e,
                    ]);
                }
            }
            else{
                return response()->json([
                    'success'=>false,
                    'message'=> 'Unknown Request!'
                   ]);
            }
        }
            //return $this->login($request);

     }




     public function logout(Request $request){

        if(auth('api')->check()){
            auth('api')->user()->tokens()->first()->revoke() ;
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
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
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

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
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $loginData = $request->validate([
            'email'=>'email|required',
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
     } else{
        return response()->json([
            'success'=>false,
            'message'=>'Invalid Credintials'
     ]);
     } 
    }



    public function register(Request $request){

        $rules = [
            'email'=>'email|required|unique:users',
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
                    'email'=>'email|required',
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
                    $user->password =$encryptedPass;
                    $user->is_company=$request->is_company;
                    $user->save();
                    $profile = new Company;
                    $profile->name=$request->name;
                    $profile->user_id=$user->id;
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
                'email'=>'email|required',
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
                $user->password =$encryptedPass;
                $user->is_company=$request->is_company;
                $user->save();
                $profile = new Customer;
                $profile->first_name=$request->first_name;
                $profile->last_name=$request->last_name;
                $profile->user_id=$user->id;
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
}

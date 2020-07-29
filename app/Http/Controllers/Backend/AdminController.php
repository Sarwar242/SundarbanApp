<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        return view('backend.index');
    }    
    
    public function companyCreateForm()
    {
        return view('backend.company.add');
    }
    public function customerCreateForm()
    {
        return view('backend.company.add');
    }

    public function userCreate(Request $request){

        $rules = [
            'email'=>'email|required|unique:users',
            'password' => 'required|min:8|confirmed',
            'is_company' => 'required|boolean',
        ];
     
        $this->validate($request, $rules);
   

        $encryptedPass= Hash::make($request->password);
        if($request->is_company==1){
            $this->validate($request,[
                'email'=>'email|required',
                'password' => 'required|min:8|confirmed',
                'is_company' => 'required|boolean',
                'name' => 'required|string',
                'owners_name' => 'nullable|string',
            ]);

        
            try {
                $user = new User;
                $user->email =$request->email;
                $user->password =$encryptedPass;
                $user->is_company=$request->is_company;
                $user->save();
                $profile = new Company;
                $profile->name=$request->name;
                $profile->user_id=$user->id;
                $profile->owners_name=$user->owners_name;
                $profile->save();
                session()->flash('success', 'A Company has been created!!');
                return redirect()->route('admin.company.create');
            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.company.create');
            }
        } 
        else if($request->is_company==0){
            
            $vthis->validate($request,[
                'email'=>'email|required',
                'password' => 'required|min:8',
                'is_company' => 'required|boolean',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);
        
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
                session()->flash('success', 'A Customer has been created!!');
                return redirect()->route('admin.dashboard');
            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.dashboard');
            }
        }
        else{
            session()->flash('failed', 'Invalid Request!');
            return back();
        }
    }
}

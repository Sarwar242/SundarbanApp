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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public function admins()
    {
        return view('backend.admin.index');
    }    
    

    public function userCreate(Request $request){

        $rules = [
            'phone'=>'phone|required|unique:users',
            'password' => 'required|min:8|confirmed',
            'is_company' => 'required|boolean',
        ];
     
        $this->validate($request, $rules);
   

        $encryptedPass= Hash::make($request->password);
        if($request->is_company==1){
            $this->validate($request,[
                'email'=>'email|nullable',
                'password' => 'required|min:8|confirmed',
                'is_company' => 'required|boolean',
                'name' => 'required|string',
                'owners_name' => 'nullable|string',
            ]);

        
            try {
                $user = new User;
                $user->phone =$request->phone;
                $user->email =$request->email;
                $user->password =$encryptedPass;
                $user->is_company=$request->is_company;
                $user->save();
                $profile = new Company;
                $profile->name=$request->name;
                $profile->bn_name=$request->bn_name;
                $profile->image="default.png";
                $profile->user_id=$user->id; 
                $profile->admin_id=Auth::guard('admin')->user()->id; 
                $profile->owners_name=$request->owners_name;
                $profile->save();
                session()->flash('success', 'A Company has been created!!');
                return view('backend.company.add')->with('profile',$profile->id);
            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.company.create');
            }
        } 
        else if($request->is_company==0){
            
            $this->validate($request,[
                'email'=>'email|nullable',
                'password' => 'required|min:8',
                'is_company' => 'required|boolean',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);
        
            try{                   
                $user = new User;
                $user->phone =$request->phone;
                $user->email =$request->email;
                $user->password =$encryptedPass;
                $user->is_company=$request->is_company;
                $user->save();
                $profile = new Customer;
                $profile->first_name=$request->first_name;
                $profile->last_name=$request->last_name;
                $profile->image="default.png";
                $profile->user_id=$user->id;
                $profile->admin_id=Auth::guard('admin')->user()->id; 

                $username = Str::slug($request->first_name . "-" . $request->last_name);
                $i = 0;
                while(Customer::whereUsername($username)->exists())
                {
                    $i++;
                    $username = $username . $i;
                }
                $profile->username =$username;

                $profile->save();
                session()->flash('success', 'A Customer has been created!!');
                return view('backend.customer.add')->with('profile',$profile->id);
            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.customer.create');
            }
        }
        else{
            session()->flash('failed', 'Invalid Request!');
            return back();
        }
    }


    public function createAdmin(){
        return view('backend.admin.add');
    }
    public function storeAdmin(Request $request){
        $this->validate($request,[
            'email'=>'email|required|unique:admins',
            'password' => 'required|min:8|confirmed',
            'type' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
        ]);

        $encryptedPass= Hash::make($request->password);

        try{                   
            $admin = new Admin;
            $admin->email =$request->email;
            $admin->password =$encryptedPass;
            $admin->first_name=$request->first_name;
            $admin->last_name=$request->last_name;
            $admin->image="default.png";
            $admin->type=$request->type;
            $admin->admin_id=Auth::guard('admin')->user()->id; 

            $username = Str::slug($request->first_name . "-" . $request->last_name);
            $i = 0;
            while(Admin::whereUsername($username)->exists())
            {
                $i++;
                $username = $username . $i;
            }
            $admin->username =$username;

            $admin->save();
            session()->flash('success', 'An Admin has been created!!');
            return redirect()->route('admin.admin.create');
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.admin.create');
        }
    }
    
    public function editAdmin($id){
        $admin = Admin::find($id);
        return view('backend.admin.edit')->with('admin',$admin);
    }
    
    public function updateAdmin(Request $request, $id){
        $this->validate($request,[
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nid' => 'nullable|string',
            'type' => 'nullable|string',
            'email' => 'required|email',
            'phone1' => 'nullable|numeric|phone',
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
            $admin = Admin::find($id);
            $admin->first_name =$request->first_name;
            $admin->last_name =$request->last_name;
            $admin->email =$request->email;
            $admin->phone1 =$request->phone1;
            $admin->phone2=$request->phone2;
            
            $admin->nid =$request->nid;
            if(!is_null($request->type))
                $admin->type =$request->type;
         //   $admin->gender =$request->gender;
            $admin->about =$request->about;
            $admin->bn_about =$request->bn_about;
            $admin->street =$request->street;
            $admin->bn_street =$request->bn_street;
            $admin->zipcode =$request->zipcode;
            $admin->location =$request->location;
            $admin->bn_location =$request->bn_location;
            $admin->union_id =$request->union_id;
            $admin->upazilla_id =$request->upazilla_id;
            $admin->district_id =$request->district_id;
            $admin->division_id =$request->division_id;

        //    dd($request);

            if(!is_null($request->password)){
                $encryptedPass= Hash::make($request->password);
                $admin->password =$request->password;
            }
            
            if(request()->hasFile('image')){
                if(!is_null($admin->image) && $admin->image !="default.png" &&  $admin->image !="default.jpg"){
                    $exists = Storage::disk('public')->exists('admin/'.$admin->image);
                    if($exists)
                        Storage::disk('public')->delete('admin/'.$admin->image);
                }
                $imageName = time().'.'.$request->image->extension();  
                $request->image->storeAs('/admin',$imageName,'public');
                $admin->image=$imageName;
            }

            $admin->save();

            session()->flash('success', 'The admin has been Updated!!');
                return redirect()->route('admin.admin.update',$admin->id);
            }catch(Exception $e){
                session()->flash('failed', 'Error occured! --'.$e);
                return redirect()->route('admin.admin.update',$admin->id);
            }
    }
}

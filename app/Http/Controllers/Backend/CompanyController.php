<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Customer;
use App\Models\Company;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Auth;


class CompanyController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){
        return view('backend.company.index');
    }  
    
    public function create()
    {
        return view('backend.company.add');
    }

    public function edit($id){
        $company= Company::find($id);

        return view('backend.company.edit')->with('company',$company);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|numeric|phone',
            'bn_name' => 'nullable|string',
            'owners_name' => 'nullable|string',
            'owners_nid' => 'nullable|string',
            'phone1' => 'nullable|numeric|phone',
            'phone2' => 'nullable|numeric|phone',
            'description' => 'nullable|string',
            'bn_description' => 'nullable|string',
            'street' => 'nullable|string',
            'bn_street' => 'nullable|string',
            'location' => 'nullable|string',
            'bn_location' => 'nullable|string',
            'website' => 'nullable|string',
            'business_type' => 'nullable|string',
            'type' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'union_id' => 'nullable|numeric',
            'upazilla_id' => 'nullable|numeric',
            'district_id' => 'nullable|numeric',
            'division_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'subcategory_id' => 'nullable|numeric',
            'password'=>'nullable|min:8|confirmed',
            'image' => 'nullable|file|image|max:3000',   
        ]);
       
        try{
            $company = Company::find($id);
            $company->name =$request->name;
            $company->user->phone =$request->phone;
            $company->user->email =$request->email;
            //dd($company->user->email);
            $company->bn_name =$request->bn_name;
            $company->owners_name =$request->owners_name;
            $company->owners_nid =$request->owners_nid;
            $company->phone1 =$request->phone1;
            $company->phone2 =$request->phone2;
            $company->description =$request->description;
            $company->bn_description =$request->bn_description;
            $company->location =$request->location;
            $company->bn_location =$request->bn_location;
            $company->street =$request->street;
            $company->bn_street =$request->bn_street;
            $company->website =$request->website;
            if(request()->has('business_type'))
                $company->business_type =$request->business_type;
            if(request()->has('type'))
                $company->type =$request->type;
            $company->zipcode =$request->zipcode;
            $company->union_id =$request->union_id;
            $company->upazilla_id =$request->upazilla_id;
            $company->district_id =$request->district_id;
            $company->division_id =$request->division_id;
            $company->category_id =$request->category_id;
            $company->subcategory_id =$request->subcategory_id;
           // dd($request);

            if(!is_null($request->password)){
                $encryptedPass= Hash::make($request->password);
                $company->user->password =$request->password;
            }
            
            if(request()->hasFile('image')){
                if(!is_null($company->image) && $company->image !="default.png" &&  $company->image !="default.jpg"){
                    $exists = Storage::disk('public')->exists('company/'.$company->image);
                    if($exists)
                        Storage::disk('public')->delete('company/'.$company->image);
                }
                $imageName = time().'.'.$request->image->extension();  
                $request->image->storeAs('/company',$imageName,'public');
                $company->image=$imageName;
            }

            $company->user->save();
            $company->save();

            session()->flash('success', 'The Company Profile has been updated!!');
            return redirect()->route('admin.company.update',$company->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }
}

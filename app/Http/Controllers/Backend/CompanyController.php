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
use Auth;


class CompanyController extends Controller
{

    public function index(){
        return view('backend.company.index');
    }  
    
    
    public function edit($id){
        $company= Company::find($id);

        return view('backend.company.edit')->with('company',$company);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|email',
            'bn_name' => 'nullable|string',
            'owners_name' => 'nullable|string',
            'owners_nid' => 'nullable|string',
            'phone1' => 'nullable|numeric|phone',
            'phone2' => 'nullable|numeric|phone',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'street' => 'nullable|string',
            'website' => 'nullable|string',
            'business_type' => 'nullable|string',
            'type' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'union_id' => 'nullable|string',
            'upazilla_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'division_id' => 'nullable|string',
            'image' => 'nullable|file|image|max:3000',   
        ]);
       
        try{
            $company = Company::find($id);
            $company->name =$request->name;
            $company->user->email =$request->email;
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

            session()->flash('success', 'The Company Profile has been updated!!');
            return redirect()->route('admin.company.update',$company->id);
        }catch(Exception $e){
            session()->flash('failed', 'Error occured! --'.$e);
            return redirect()->route('admin.dashboard');
        }
    }
}

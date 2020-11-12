<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function companies(Request $request)
    {
        $companies= Company::all();
        foreach($companies as $company):
            $user=$company->user;
            $category=$company->category;
            $subcategory = $company->subcategory;
            $division = $company->division;
            $district=$company->district;
            $upazilla=$company->upazilla;
            $union=$company->union;
        endforeach;

        return response()->json([
            'success'=>true,
            'companies'=>$companies
           ]);
    }

    public function profile(Request $request)
    {
        $company= Company::find($request->id);
        if(is_null($company)){
            return response()->json([
                'success'=>false,
                'message'=>'No company found in database!'
               ]);
        }
        $category=$company->category;
        $subcategory = $company->subcategory;
        $division = $company->division;
        $district=$company->district;
        $upazilla=$company->upazilla;
        $union=$company->union;
        $products = $company->products;
        $user=User::find($company->user_id);
        $following=$user->followings()->get()->count() ;
        $followers=$company->followers()->get()->count() ;


        return response()->json([
            'success'=>true,
            'company'=>$company,
            'followers'=>$followers,
            'following'=>$following
           ]);
    }

    public function update(Request $request)
    {
        $company = Company::find($request->id);
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|numeric|phone|unique:users,phone,'.$company->user->id,

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
            'open' => 'nullable',
            'close' => 'nullable|after:open',
            'off_day' => 'nullable|string',
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
            'image' => 'nullable|file|image|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try{
            $slug_change =0;
            if($company->name!=$request->name){
                $slug_change=1;
            }
            if($slug_change==1){
                $slug = Str::slug(str_replace( ' ', '-', $request->name));
                $i = 0;
                while(Company::whereSlug($slug)->exists())
                {
                    $i++;
                    $slug = $slug ."-". $i;
                }
                $company->slug =$slug;
            }

            $company->name =$request->name;
            $company->user->phone =$request->phone;
            if(request()->has('email'))
                $company->user->email =$request->email;

            if(request()->has('bn_name'))
                $company->bn_name =$request->bn_name;
           // $company->code =$request->code;
            if(request()->has('owners_name'))
                $company->owners_name =$request->owners_name;
            if(request()->has('owners_nid'))
                $company->owners_nid =$request->owners_nid;
            if(request()->has('phone1'))
                $company->phone1 =$request->phone1;
            if(request()->has('phone2'))
                $company->phone2 =$request->phone2;

            if(request()->has('description'))
                $company->description =$request->description;
            if(request()->has('bn_description'))
                $company->bn_description =$request->bn_description;
            if(request()->has('location'))
                $company->location =$request->location;
            if(request()->has('bn_location'))
                $company->bn_location =$request->bn_location;
            if(request()->has('open'))
                $company->open = $request->open;
            if(request()->has('close'))
                $company->close = $request->close;
            if(request()->has('off_day'))
                $company->off_day = $request->off_day;
            if(request()->has('street'))
                $company->street =$request->street;
            if(request()->has('bn_street'))
                $company->bn_street =$request->bn_street;
            if(request()->has('website'))
                $company->website =$request->website;
            if(request()->has('business_type'))
                $company->business_type =$request->business_type;
            if(request()->has('type'))
                $company->type =$request->type;
            if(request()->has('zipcode'))
                $company->zipcode =$request->zipcode;
            if(request()->has('union_id'))
                $company->union_id =$request->union_id;
            if(request()->has('upazilla_id'))
                $company->upazilla_id =$request->upazilla_id;
            if(request()->has('district_id'))
                $company->district_id =$request->district_id;
            if(request()->has('division_id'))
                $company->division_id =$request->division_id;
            if(request()->has('category_id'))
                $company->category_id =$request->category_id;
            if(request()->has('subcategory_id'))
                $company->subcategory_id =$request->subcategory_id;

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

            return response()->json([
                "success"  => true,
                "message" => "Company profile has been updated!",
                "company" => $company
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
            $company = Company::find($request->id);
            if(is_null($company)){
                return response()->json([
                    'success'=>false,
                    'message'=> 'No company found !!!'
                ]);
            }
            if (!is_null($company->image) && $company->image !="default.png" &&  $company->image !="default.jpg") {
                $exists = Storage::disk('public')->exists('company/'.$company->image);
                if($exists)
                   Storage::disk('public')->delete('company/'.$company->image);
            }
            $user_id=$company->user_id;
            $user= User::find($user_id);
            if(!is_null($user)){
                $user->delete();
            }
            else{
                $company->delete();
            }

            return response()->json([
                'success'=>true,
                'message'=>'Company Deleted!'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> ''.$e,
            ]);
        }
    }
}

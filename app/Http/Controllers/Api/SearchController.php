<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Union;
use App\Models\Upazilla;
use App\Models\District;
use App\Models\Division;

class SearchController extends Controller
{
    public function productSearch(Request $request){
        $key = $request->key;
        $results = Product::where('name', 'like',"%{$key}%")
                           ->orWhere('description', 'like', "%{$key}%")
                           ->orWhere('bn_name', 'like',  "%{$key}%")
                           ->orWhere('bn_description', 'like',  "%{$key}%")
                           ->orWhere('type', 'like',  "%{$key}%")
                           ->orWhere('price', 'like',  "%{$key}%")
                           ->get();

        if(is_null($results))
            return response()->json([
                'success'=>false,
                'message'=>'Sorry No product found!',
            ]);

        foreach ($results as $product) {
            $product->unit;
            $product->category;
            $product->subcategory;
            $product->company;
            $product->images;
        }
        return response()->json([
            'success'=>true,
            'products'=>$results,
           ]);
    }

    public function companySearch(Request $request){
        $key = $request->key;
        $companies = Company::where('name', 'like',"%{$key}%")
                           ->orWhere('description', 'like', "%{$key}%")
                           ->orWhere('bn_name', 'like',  "%{$key}%")
                           ->orWhere('bn_description', 'like',  "%{$key}%")
                           ->orWhere('type', 'like',  "%{$key}%")
                           ->orWhere('website', 'like',  "%{$key}%")
                           ->orWhere('street', 'like',  "%{$key}%")
                           ->orWhere('location', 'like',  "%{$key}%")
                           ->orWhere('zipcode', 'like',  "%{$key}%")
                           ->get();

        if(is_null($companies))
            return response()->json([
                'success'=>false,
                'message'=>'Sorry, No company found!',
            ]);

        foreach($companies as $company){
            $user = $company->user;
            $category = $company->category;
            $subcategory = $company->subcategory;
            $division = $company->division;
            $district = $company->district;
            $upazilla = $company->upazilla;
            $union = $company->union;
            $products = $company->products;
            foreach ($products as $product) {
                $product->unit;
                $product->category;
                $product->subcategory;
                $product->images;
            }
            $company->following = $company->user->followings()->get()->count();
            $company->followers = $company->followers()->get()->count();
            $company->ratings   = $company->ratings()->get()->avg('rating');
        }
        return response()->json([
            'success'=>true,
            'companies'=>$companies,
           ]);
    }

    public function searchByType(Request $request){
        $key = $request->key;
        $products = Product::where('type', '=', $key)
                            ->orderBy('name', 'ASC')->get();
        foreach ($products as $product) {
            $product->unit;
            $product->category;
            $product->subcategory;
            $product->company;
            $product->images;
        }
        $companies = Company::where('business_type', '=', $key)
                            ->orderBy('name', 'ASC')->get();
        foreach($companies as $company){
            $user = $company->user;
            $division = $company->division;
            $district = $company->district;
            $upazilla = $company->upazilla;
            $union = $company->union;

            $company->following = $company->user->followings()->get()->count();
            $company->followers = $company->followers()->get()->count();
            $company->ratings   = $company->ratings()->get()->avg('rating');
        }
        return response()->json([
            'success'=>true,
            'products'=>$products,
            'companies' => $companies,
           ]);
    }

    public function productByType(Request $request){
        $key = $request->key;
        $products = Product::where('type', '=', $key)
                            ->orderBy('name', 'ASC')->get();
        foreach ($products as $product) {
            $product->unit;
            $product->category;
            $product->subcategory;
            $product->company;
            $product->images;
        }
        return response()->json([
            'success'=>true,
            'products'=>$products,
        ]);
    }

    public function companyByType(Request $request){
        $key = $request->key;
        $companies = Company::where('business_type', '=', $key)
                            ->orderBy('name', 'ASC')->get();
        if(!is_null($companies)){
            foreach($companies as $company){
                $user = $company->user;
                $category = $company->category;
                $subcategory = $company->subcategory;
                $division = $company->division;
                $district = $company->district;
                $upazilla = $company->upazilla;
                $union = $company->union;
                $products = $company->products;
                foreach ($products as $product) {
                    $product->unit;
                    $product->category;
                    $product->subcategory;
                    $product->images;
                }
                $company->following = $company->user->followings()->get()->count();
                $company->followers = $company->followers()->get()->count();
                $company->ratings   = $company->ratings()->get()->avg('rating');
            }
        }
        return response()->json([
            'success'=>true,
            'companies'=>$companies,
        ]);
    }
    public function companyByLocation(Request $request){
        $key = $request->key;
        if(request()->has('union_id') && !is_null($request->union_id)){
            $companies = Company::where('union_id', '=', $request->union_id)
                                ->orderBy('name', 'ASC')->get();
            if(!is_null($companies)){
                foreach($companies as $company){
                    $user = $company->user;
                    $category = $company->category;
                    $subcategory = $company->subcategory;
                    $division = $company->division;
                    $district = $company->district;
                    $upazilla = $company->upazilla;
                    $union = $company->union;
                    $products = $company->products;
                    foreach ($products as $product) {
                        $product->unit;
                        $product->category;
                        $product->subcategory;
                        $product->images;
                    }
                    $company->following = $company->user->followings()->get()->count();
                    $company->followers = $company->followers()->get()->count();
                    $company->ratings   = $company->ratings()->get()->avg('rating');
                }
            }
            return response()->json([
                'success'=>true,
                'companies'=>$companies,
            ]);
        }else{
            if(request()->has('upazilla_id') && !is_null($request->upazilla_id)){
                $companies = Company::where('upazilla_id', '=', $request->upazilla_id)
                                    ->orderBy('name', 'ASC')->get();
                if(!is_null($companies)){
                    foreach($companies as $company){
                        $user = $company->user;
                        $category = $company->category;
                        $subcategory = $company->subcategory;
                        $division = $company->division;
                        $district = $company->district;
                        $upazilla = $company->upazilla;
                        $union = $company->union;
                        $products = $company->products;
                        foreach ($products as $product) {
                            $product->unit;
                            $product->category;
                            $product->subcategory;
                            $product->images;
                        }
                        $company->following = $company->user->followings()->get()->count();
                        $company->followers = $company->followers()->get()->count();
                        $company->ratings   = $company->ratings()->get()->avg('rating');
                    }
                }
                return response()->json([
                    'success'=>true,
                    'companies'=>$companies,
                ]);
            }else{
                if(request()->has('district_id') && !is_null($request->district_id)){
                    $companies = Company::where('district_id', '=', $request->district_id)
                                        ->orderBy('name', 'ASC')->get();
                    if(!is_null($companies)){
                        foreach($companies as $company){
                            $user = $company->user;
                            $category = $company->category;
                            $subcategory = $company->subcategory;
                            $division = $company->division;
                            $district = $company->district;
                            $upazilla = $company->upazilla;
                            $union = $company->union;
                            $products = $company->products;
                            foreach ($products as $product) {
                                $product->unit;
                                $product->category;
                                $product->subcategory;
                                $product->images;
                            }
                            $company->following = $company->user->followings()->get()->count();
                            $company->followers = $company->followers()->get()->count();
                            $company->ratings   = $company->ratings()->get()->avg('rating');
                        }
                    }
                    return response()->json([
                        'success'=>true,
                        'companies'=>$companies,
                    ]);
                }else{
                    if(request()->has('division_id') && !is_null($request->division_id)){
                        $companies = Company::where('division_id', '=', $request->division_id)
                                            ->orderBy('name', 'ASC')->get();
                        if(!is_null($companies)){
                            foreach($companies as $company){
                                $user = $company->user;
                                $category = $company->category;
                                $subcategory = $company->subcategory;
                                $division = $company->division;
                                $district = $company->district;
                                $upazilla = $company->upazilla;
                                $union = $company->union;
                                $products = $company->products;
                                foreach ($products as $product) {
                                    $product->unit;
                                    $product->category;
                                    $product->subcategory;
                                    $product->images;
                                }
                                $company->following = $company->user->followings()->get()->count();
                                $company->followers = $company->followers()->get()->count();
                                $company->ratings   = $company->ratings()->get()->avg('rating');
                            }
                        }
                        return response()->json([
                            'success'=>true,
                            'companies'=>$companies,
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'success'=>false,
            'message'=>"Invalid request!",
        ]);
    }

    public function productByLocation(Request $request){
        $key = $request->key;
        if(request()->has('union_id') && !is_null($request->union_id)){

            if(request()->has('key') && !is_null($request->key)){
                $products = Product::where('products.name','like',"%{$key}%")
                                    ->orWhere('products.description', 'like', "%{$key}%")
                                    ->orWhere('products.bn_name', 'like',  "%{$key}%")
                                    ->orWhere('products.bn_description', 'like',  "%{$key}%")
                                    ->orWhere('products.type', 'like',  "%{$key}%")
                                    ->orWhere('products.price', 'like',  "%{$key}%")
                                    ->join('companies','products.company_id','=','companies.id')
                                    ->where('companies.union_id','=',$request->union_id)
                                    ->get(['products.*']);


                foreach ($products as $product) {
                    $product->unit;
                    $product->category;
                    $product->subcategory;
                    $product->company;
                    $product->images;
                }

                return response()->json([
                    'success'=>true,
                    'products'=>$products,
                ]);
            }
            else{
                $union = Union::find($request->union_id);
                $products=$union->products;
                foreach ($products as $product) {
                    $product->unit;
                    $product->category;
                    $product->subcategory;
                    $product->company;
                    $product->images;
                }
                return response()->json([
                    'success'=>true,
                    'products'=>$products,
                ]);
            }
        }else{
            if(request()->has('upazilla_id') && !is_null($request->upazilla_id)){
                if(request()->has('key') && !is_null($request->key)){
                    $products = Product::where('products.name','like',"%{$key}%")
                                        ->orWhere('products.description', 'like', "%{$key}%")
                                        ->orWhere('products.bn_name', 'like',  "%{$key}%")
                                        ->orWhere('products.bn_description', 'like',  "%{$key}%")
                                        ->orWhere('products.type', 'like',  "%{$key}%")
                                        ->orWhere('products.price', 'like',  "%{$key}%")
                                        ->join('companies','products.company_id','=','companies.id')
                                        ->where('companies.upazilla_id','=',$request->upazilla_id)
                                        ->get(['products.*']);

                    foreach ($products as $product) {
                        $product->unit;
                        $product->category;
                        $product->subcategory;
                        $product->company;
                        $product->images;
                    }
                    return response()->json([
                        'success'=>true,
                        'products'=>$products,
                    ]);
                }
                else{
                    $upazilla = Upazilla::find($request->upazilla_id);
                    $products=$upazilla->products;
                    foreach ($products as $product) {
                        $product->unit;
                        $product->category;
                        $product->subcategory;
                        $product->company;
                        $product->images;
                    }
                    return response()->json([
                        'success'=>true,
                        'products'=>$products,
                    ]);
                }
            }else{
                if(request()->has('district_id') && !is_null($request->district_id)){
                    if(request()->has('key') && !is_null($request->key)){
                        $products = Product::where('products.name','like',"%{$key}%")
                                            ->orWhere('products.description', 'like', "%{$key}%")
                                            ->orWhere('products.bn_name', 'like',  "%{$key}%")
                                            ->orWhere('products.bn_description', 'like',  "%{$key}%")
                                            ->orWhere('products.type', 'like',  "%{$key}%")
                                            ->orWhere('products.price', 'like',  "%{$key}%")
                                            ->join('companies','products.company_id','=','companies.id')
                                            ->where('companies.district_id','=',$request->district_id)
                                            ->get(['products.*']);

                        foreach ($products as $product) {
                            $product->unit;
                            $product->category;
                            $product->subcategory;
                            $product->company;
                            $product->images;
                        }
                        return response()->json([
                            'success'=>true,
                            'products'=>$products,
                        ]);
                    }
                    else{
                        $district = District::find($request->district_id);
                        $products=$district->products;
                        foreach ($products as $product) {
                            $product->unit;
                            $product->category;
                            $product->subcategory;
                            $product->company;
                            $product->images;
                        }
                        return response()->json([
                            'success'=>true,
                            'products'=>$products,
                        ]);
                    }
                }else{
                    if(request()->has('division_id') && !is_null($request->division_id)){
                        if(request()->has('key') && !is_null($request->key)){
                            $products = Product::where('products.name','like',"%{$key}%")
                                                ->orWhere('products.description', 'like', "%{$key}%")
                                                ->orWhere('products.bn_name', 'like',  "%{$key}%")
                                                ->orWhere('products.bn_description', 'like',  "%{$key}%")
                                                ->orWhere('products.type', 'like',  "%{$key}%")
                                                ->orWhere('products.price', 'like',  "%{$key}%")
                                                ->join('companies','products.company_id','=','companies.id')
                                                ->where('companies.division_id','=',$request->division_id)
                                                ->get(['products.*']);

                            foreach ($products as $product) {
                                $product->unit;
                                $product->category;
                                $product->subcategory;
                                $product->company;
                                $product->images;
                            }
                            return response()->json([
                                'success'=>true,
                                'products'=>$products,
                            ]);
                        }
                        else{
                            $division = Division::find($request->division_id);
                            $products=$division->products;
                            foreach ($products as $product) {
                                $product->unit;
                                $product->category;
                                $product->subcategory;
                                $product->company;
                                $product->images;
                            }
                            return response()->json([
                                'success'=>true,
                                'products'=>$products,
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json([
            'success'=>false,
            'message'=>"Invalid request!",
        ]);
    }
}

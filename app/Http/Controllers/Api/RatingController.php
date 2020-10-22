<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Rating;

class RatingController extends Controller
{
    public function rate(Request $request){
        $company = Company::find($request->company_id);
        $user = User::find($request->user_id);
        $has_rated=Rating::where('user_id', '=',$request->user_id )
        ->where('company_id', '=',$request->company_id)->first();
        if(!is_null($has_rated)){
            $has_rated->rating=$request->rating;
            $has_rated->save();
            return response()->json([
                'success'=>'true',
                'message'=>'rating updated',
                'rating'=>$has_rated->rating
                ]);
        }
        $rate = new Rating;
        $rate->user_id = $request->user_id;
        $rate->company_id = $request->company_id;
        $rate->rating = $request->rating;
        $rate->save();
        return response()->json([
            'success'=>'true',
            'message'=>'new Rated',
            'rating'=>$rate->rating
        ]);
    }
   
}

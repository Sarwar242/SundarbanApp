<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    public function follow(Request $request){

        $company = Company::find($request->company_id);
        $user = User::find($request->user_id);
        $is_following=Follow::where('user_id', '=',$request->user_id )
        ->where('company_id', '=',$request->company_id)->first();
        if(!is_null($is_following)){
            $is_following->delete();
            return response()->json(['success'=>'true','message'=>'unfollowed']);
        }
        $follow = new Follow;
        $follow->user_id = $request->user_id;
        $follow->company_id = $request->company_id;
        $follow->save();
        return response()->json(['success'=>'true','message'=>'followed']);
    }
}

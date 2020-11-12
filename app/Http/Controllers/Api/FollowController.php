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

    public function followers(Request $request){
        $company= Company::find($request->id);
        if(is_null($company)){
            return response()->json([
                'success'=>false,
                'message'=>'No company found in database!'
               ]);
        }

        $followers=$company->followers()->get();
        foreach($followers as $follower){
            if($follower->is_company==0){
                $follower->customer;
            }
            else{
                $follower->company;
            }
        }
        return response()->json([
            'success'=>true,
            'followers'=>$followers
           ]);
    }


    public function following(Request $request){
        $user= User::find($request->id);
        if(is_null($user)){
            return response()->json([
                'success'=>false,
                'message'=>'No User found in database!'
               ]);
        }

        $followings=$user->followings()->get();
        foreach($followings as $following){
            if($following->is_company==0){
                $following->customer;
            }
            else{
                $following->company;
            }
        }
        return response()->json([
            'success'=>true,
            'following'=>$followings
           ]);
    }
}

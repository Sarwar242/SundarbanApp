<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function AllNotifications(Request $request)
    {
        $user = User::find($request->user_id);
        if(is_null($user)){
            return response()->json([
                'success'=>false,
                'message'=>'No user found in database, invalid user id!'
               ]);
        }
        $notifications=$user->notifications;
        return response()->json([
            "success"  => true,
            "notifications" => $notifications
        ]);
    }
   // $user->unreadNotifications->markAsRead();
}

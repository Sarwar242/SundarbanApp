<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    public function ReadAll(Request $request)
    {
        $user = User::find($request->user_id);
        if(is_null($user)){
            return response()->json([
                'success'=>false,
                'message'=>'No user found in the database, invalid user id!'
               ]);
        }
        $user->unreadNotifications->markAsRead();
        return response()->json([
            "success"  => true,
            'message'=>'Marked as read all unread notifications'
        ]);
    }


    public function DeleteAll(Request $request)
    {
        $user = User::find($request->user_id);
        if(is_null($user)){
            return response()->json([
                'success'=>false,
                'message'=>'No user found in the database, invalid user id!'
               ]);
        }
        $user->notifications()->delete();
        return response()->json([
            "success"  => true,
            'message'=>'Deleted all notifications'
        ]);
    }


    public function DeleteAlreadyRead(Request $request)
    {
        $user = User::find($request->user_id);
        if(is_null($user)){
            return response()->json([
                'success'=>false,
                'message'=>'No user found in the database, invalid user id!'
               ]);
        }
        $user->readNotifications()->delete();
        return response()->json([
            "success"  => true,
            'message'=>'Deleted already read notifications!'
        ]);
    }


    public function DeleteOne(Request $request)
    {
        $notification = DB::table('notifications')
                            ->where('id','=', $request->id)
                            ->get();

        if(is_null($notification)){
            return response()->json([
                "success"  => false,
                'message'=>'Invalid Notification id!'
            ]);
        }

        DB::table('notifications')
            ->where('id','=', $request->id)
            ->delete();

        return response()->json([
            "success"  => true,
            'message'=>'Notification deleted!'
        ]);
    }


    public function ReadOne(Request $request)
    {
        $notification = DB::table('notifications')
                            ->where('id','=', $request->id)
                            ->get();
        if(is_null($notification)){
            return response()->json([
                "success"  => false,
                'message'=>'Invalid Notification id!'
            ]);
        }

        DB::table('notifications')
            ->where('id','=', $request->id)
            ->update(['read_at' => now()]);

        return response()->json([
            "success"  => true,
            'message'=>'Notification marked as read!'
        ]);
    }
   // $user->unreadNotifications->markAsRead();
}

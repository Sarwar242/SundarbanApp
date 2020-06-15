<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:4,1')->only('verify', 'resend');
    }


    public function verify(Request $request)
    {
        auth()->loginUsingId($request->route('id'));

        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            //return redirect($this->redirectPath());

            return response()->json(['success'=>false,
            'message'=>'Already Verified']);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json(['verified'=>true,
        'success'=>true,
        'message'=>'SuccessFully Verified']);
        //return redirect($this->redirectPath())->with('verified', true);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success'=>false,
                'message'=>'Already Verified'
            ]);
        }

        $request->user()->sendEmailVerificationNotification();
        if($request->wantsJson()){
            return response()->json(['success'=>true,
            'message'=>'Email Sent']);
        }

        return response()->json(['success'=>true,
            'message'=>'Email Sent']);
        //return back()->with('resent', true);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $reqtuest, $response){
        return response(['success'=>true,
            'message'=>$response]);
    }

    protected function sendResetLinkFailedResponse(Request $reqtuest, $response){
        return response(['success'=>false,
            'error'=>$response],422);
    }

}

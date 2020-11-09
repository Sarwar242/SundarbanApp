<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\Admin;
use Auth;

class ResetPasswordController extends Controller
{

    use SendsPasswordResetEmails,ResetsPasswords;

    protected $redirectTo = '/admin';
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        session()->flash('failedx','Something is wrong!');
        return $response == Password::PASSWORD_RESET
                    ? redirect()->route('admin.login')
                    : $this->sendResetFailedResponse($request, $response);
    }
    /**$this->sendResetResponse($request, $response)
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request, $this->rules());

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        session()->flash("failed", "Something is wrong. Please check...");
        return $response == Password::RESET_LINK_SENT
        ? view('backend.auth.success_mail')
        : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('backend.auth.reset_form')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    //$this->sendResetLinkResponse($request, $response)
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',

        ];
    }

    public function broker()
    {
        return Password::broker('admins');
    }
    protected function validationErrorMessages()
    {
        return [];
    }


}

<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Auth;
use Route;

class AdminAuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');;
    }
    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
      return view('backend.auth.login');
    }

    public function showLinkRequestForm()
    {
      return view('backend.auth.reset_email');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('admin.dashboard'));
      }
      session()->flash('successx','Invalid Credentials');
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}

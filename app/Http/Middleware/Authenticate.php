<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    public function handle($request, Closure $next, ...$guards)
    {
        $guard =Arr::first($guards);
        if (Auth::guard($guard)->guest()) {
            if ($guard === 'api') {
                return response()->json([
                    'success'=>false,
                    'message'=>'Unauthorized'
                ],401);
            }else if($guard === 'admin'){
                return redirect()->guest('/admin/login');
            }

            else {
                return redirect()->guest('login');
            }
        }
        return $next($request);
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (array_first($this->guards) === 'admin') {
                return route('admin.login');
            }
            return route('login');
        }
    }
}

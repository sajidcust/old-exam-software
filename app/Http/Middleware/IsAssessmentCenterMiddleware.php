<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAssessmentCenterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth()->user()){
            if(Auth::user()->user_role == 2){
                return $next($request);
            } else if(Auth::user()->user_role == 1) {
                return redirect()->to('admin/dashboard');
            }else if(Auth::user()->user_role == 3){
                return redirect()->to('dataentry/dashboard');
            } else {
                return redirect()->to('users/permissiondenied');
            }
        }

        return redirect()->to('users/login');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            if(Auth::user()->role == '0') {
                //if admin
                return $next($request);
            } else {
                return redirect('/welcome')->with('message', 'Access denied as you are not an admin.');
            }
        } else {
            return redirect('/login')->with('message', 'Sign in to access the admin portal');
        }
    }
}

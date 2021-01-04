<?php

namespace App\Http\Middleware;

use Closure;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('role')){
            return $next($request);
         }else{
             $request->session()->flash('msg', 'User role could not detect. Please login first.');
             $request->session()->flash('type', 'danger');
             return redirect()->route('login');
         }
    }
}

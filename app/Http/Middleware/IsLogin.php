<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class IsLogin
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

        if(is_null(session('USER_ID'))){
            return redirect('/');
        }

        if(empty($request->route()->uri()) || 
        $request->route()->uri() == "login" || 
        $request->route()->uri() == "register" && 
        !is_null(session('USER_ID'))
        ){
            return redirect('subjects');
        }
        
        return $next($request);
    }
}

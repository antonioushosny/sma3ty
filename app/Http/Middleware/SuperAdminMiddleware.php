<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Response;
use Closure;
use Auth;
class SuperAdminMiddleware
{

    public function handle($request, Closure $next)
    {
     
        if ($request->user() && $request->user()->role != 'admin')
        {
          
            $role = 'admin';
            return view('unauthorized',compact('role'));
        }
        return $next($request);
    

    }
}

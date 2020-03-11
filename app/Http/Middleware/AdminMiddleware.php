<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Response;
use Closure;

class AdminMiddleware
{
  
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->role != 'agent')
        {
            // return new Response(view('unauthorized')->with('role', 'agent'));
            $role = 'agent';
            return view('unauthorized',compact('role'));
        }
        return $next($request);
    }

}

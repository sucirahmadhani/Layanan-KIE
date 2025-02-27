<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        if (session('is_admin') !== true) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }

}

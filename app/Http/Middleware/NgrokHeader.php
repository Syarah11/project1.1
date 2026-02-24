<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NgrokHeader
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('ngrok-skip-browser-warning', 'true');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
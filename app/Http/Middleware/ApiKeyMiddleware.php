<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key is required. Please provide X-API-KEY header.'
            ], 401);
        }

        $validApiKey = config('app.api_key');

        if (!$validApiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key not configured on server.'
            ], 500);
        }

        // ✅ Gunakan hash_equals untuk keamanan
        if (!hash_equals($validApiKey, $apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key.'
            ], 401);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Middleware untuk cek role user (MODE 2 - AKTIF)
     * 
     * Cara pakai:
     * Route::middleware(['auth:sanctum', 'role:admin,super_admin'])->group(...)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles - Comma-separated roles (contoh: 'admin,super_admin')
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // ✅ MODE 2: Code AKTIF
        
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.'
            ], 401);
        }

        // Parse roles yang diizinkan
        $allowedRoles = explode(',', $roles);
        $userRole = auth()->user()->role;

        // Cek apakah user memiliki role yang diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You do not have permission to access this resource.',
                'required_roles' => $allowedRoles,
                'your_role' => $userRole
            ], 403);
        }

        return $next($request);
    }
}
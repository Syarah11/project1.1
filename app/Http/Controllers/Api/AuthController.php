<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user (publik).
     * Role dikunci 'user' — tidak bisa dimanipulasi dari request.
     *
     * Jika ingin buat admin, super_admin harus lewat endpoint terpisah
     * yang dilindungi middleware role.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // Model sudah cast 'hashed', JANGAN Hash::make lagi
            'role'     => 'user',             // ← hardcoded, aman dari manipulasi
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    /**
     * Login user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        // Hash::check tetap valid meski model pakai cast 'hashed'
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * Get authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'user'    => $request->user(),
        ]);
    }

    /**
     * Update profile user yang sedang login.
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai',
                ], 422);
            }
        }

        $dataToUpdate = [];

        if ($request->filled('name')) {
            $dataToUpdate['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $dataToUpdate['email'] = $request->email;
        }

        if ($request->filled('password')) {
            // Cast 'hashed' di model handle hashing otomatis
            $dataToUpdate['password'] = $request->password;
        }

        $user->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'user'    => $user->fresh(),
        ]);
    }
}
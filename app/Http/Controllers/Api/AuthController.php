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
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Register new user (publik).
     * Role dikunci 'user' — tidak bisa dimanipulasi dari request.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // Model sudah cast 'hashed'
            'role'     => 'user',
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
     * Update profile user (nama, email, password).
     * BE endpoint: PUT /api/profile
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
            $dataToUpdate['password'] = $request->password;
        }

        $user->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'user'    => $user->fresh(),
        ]);
    }

    /**
     * Upload / ganti foto profil (thumbnail).
     * BE endpoint: POST /api/profile/photo
     * Field: thumbnail (file: jpg/png/webp, max 2MB)
     */
    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'thumbnail.required' => 'File foto wajib dipilih.',
            'thumbnail.image'    => 'File harus berupa gambar.',
            'thumbnail.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'thumbnail.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $user = $request->user();

        // Hapus foto lama jika bukan default
        if ($user->getRawOriginal('thumbnail') && Storage::disk('public')->exists($user->getRawOriginal('thumbnail'))) {
            Storage::disk('public')->delete($user->getRawOriginal('thumbnail'));
        }

        // Simpan foto baru ke storage/app/public/thumbnails/
        $path = $request->file('thumbnail')->store('thumbnails', 'public');

        $user->update(['thumbnail' => $path]);

        return response()->json([
            'success'   => true,
            'message'   => 'Foto profil berhasil diperbarui',
            'thumbnail' => asset('storage/' . $path),
            'user'      => $user->fresh(),
        ]);
    }
}
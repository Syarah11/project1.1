<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? 'user';

        $user = User::create($data);

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

public function login(array $data)
{
    // Auth::attempt sudah handle cek email dan password
    if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return [
        'user' => $user,
        'token' => $token
    ];
}

    public function logout($user)
    {
        return $user->currentAccessToken()->delete();
    }

    public function updateProfile($user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['thumbnail'])) {
            if ($user->thumbnail) {
                \Storage::disk('public')->delete($user->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('users', 'public');
        }

        $user->update($data);
        return $user->fresh();
    }
}
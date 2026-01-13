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

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
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
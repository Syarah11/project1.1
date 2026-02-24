<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebAuthController extends Controller
{
    /**
     * Simpan token & data user ke session setelah login/register via API.
     * Dipanggil JS di blade setelah fetch /api/login atau /api/register berhasil.
     *
     * POST /auth/store-token
     */
    public function storeToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'user'  => 'required|array',
        ]);

        session([
            'api_token' => $request->token,
            'auth_user' => $request->user,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Logout: hapus session & revoke token via API.
     *
     * POST /auth/logout
     */
    public function logout(Request $request)
    {
        $token  = session('api_token');
        $apiKey = config('app.api_key'); // dari BERITA_API_KEY_BACKEND di .env

        if ($token) {
            try {
                // Hit /api/logout di server yang sama (relatif, bukan ngrok)
                // sehingga tidak terpengaruh perubahan URL ngrok
                Http::withHeaders([
                    'X-API-KEY'     => $apiKey,
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ])->post(url('/api/logout'));
            } catch (\Exception $e) {
                // Tetap lanjut logout meski revoke API gagal
            }
        }

        $request->session()->forget(['api_token', 'auth_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

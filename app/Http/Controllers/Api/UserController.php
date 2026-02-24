<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * GET /api/users
     * Tampilkan semua user dengan pagination
     * Hanya super_admin
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);

            $users = User::orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data'    => $users
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * GET /api/users/{id}
     * Tampilkan detail satu user
     * Hanya super_admin
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $user
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * PUT /api/users/{id}
     * Update data user oleh super_admin
     * Field: name (optional), email (optional), role (optional), password (optional)
     * Hanya super_admin
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            // Validasi input
            $request->validate([
                'name'     => 'sometimes|string|max:255',
                'email'    => 'sometimes|email|unique:users,email,' . $id,
                'role'     => 'sometimes|in:super_admin,admin,user',
                'password' => 'sometimes|min:8|confirmed',
            ], [
                'email.unique'        => 'Email sudah digunakan user lain.',
                'role.in'             => 'Role tidak valid. Pilih: super_admin, admin, atau user.',
                'password.min'        => 'Password minimal 8 karakter.',
                'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            ]);

            // Cegah super_admin ubah role dirinya sendiri
            if ($request->filled('role') && auth()->id() == $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa mengubah role akun Anda sendiri.'
                ], 403);
            }

            // Bangun data yang akan diupdate (hanya field yang dikirim)
            $dataToUpdate = [];

            if ($request->filled('name')) {
                $dataToUpdate['name'] = $request->name;
            }
            if ($request->filled('email')) {
                $dataToUpdate['email'] = $request->email;
            }
            if ($request->filled('role')) {
                $dataToUpdate['role'] = $request->role;
            }
            if ($request->filled('password')) {
                $dataToUpdate['password'] = Hash::make($request->password);
            }

            // Tidak ada data yang dikirim
            if (empty($dataToUpdate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang diupdate.'
                ], 422);
            }

            $user->update($dataToUpdate);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data'    => $user->fresh()
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat update user',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * DELETE /api/users/{id}
     * Hapus user
     * Hanya super_admin
     */
    public function destroy($id): JsonResponse
    {
        try {
            // Cegah super_admin hapus dirinya sendiri
            if (auth()->id() == $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa menghapus akun Anda sendiri.'
                ], 403);
            }

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user',
                'error'   => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
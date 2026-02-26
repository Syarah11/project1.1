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
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);
            $users   = User::orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json(['success' => true, 'data' => $users], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data user'], 500);
        }
    }

    /**
     * POST /api/users
     * Buat user baru oleh super_admin.
     * Role yang boleh dibuat: admin dan user saja.
     * super_admin TIDAK bisa dibuat lewat aplikasi — hanya via database langsung.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name'                  => 'required|string|max:255',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|min:8|confirmed',
                'role'                  => 'required|in:admin,user', // ← super_admin dikecualikan!
            ], [
                'role.in'    => 'Role hanya boleh: admin atau user. Super Admin hanya bisa dibuat langsung di database.',
                'email.unique' => 'Email sudah digunakan.',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password, // model cast 'hashed'
                'role'     => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data'    => $user,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat user',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * GET /api/users/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['success' => true, 'data' => $user], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }
    }

    /**
     * PUT /api/users/{id}
     * Update data user. Role yang boleh di-assign: admin dan user saja.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name'     => 'sometimes|string|max:255',
                'email'    => 'sometimes|email|unique:users,email,' . $id,
                'role'     => 'sometimes|in:admin,user', // ← super_admin dikecualikan!
                'password' => 'sometimes|min:8|confirmed',
            ], [
                'role.in' => 'Role hanya boleh: admin atau user.',
            ]);

            // Cegah ubah role diri sendiri
            if ($request->filled('role') && auth()->id() == $id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa mengubah role akun Anda sendiri.',
                ], 403);
            }

            // Cegah ubah role user yang adalah super_admin
            if ($user->role === 'super_admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Role super_admin tidak bisa diubah lewat aplikasi.',
                ], 403);
            }

            $dataToUpdate = [];
            if ($request->filled('name'))     $dataToUpdate['name']     = $request->name;
            if ($request->filled('email'))    $dataToUpdate['email']    = $request->email;
            if ($request->filled('role'))     $dataToUpdate['role']     = $request->role;
            if ($request->filled('password')) $dataToUpdate['password'] = Hash::make($request->password);

            if (empty($dataToUpdate)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data yang diupdate.'], 422);
            }

            $user->update($dataToUpdate);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data'    => $user->fresh(),
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan'], 500);
        }
    }

    /**
     * DELETE /api/users/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            if (auth()->id() == $id) {
                return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus akun Anda sendiri.'], 403);
            }

            $user = User::findOrFail($id);

            // Cegah hapus super_admin
            if ($user->role === 'super_admin') {
                return response()->json(['success' => false, 'message' => 'Akun super_admin tidak bisa dihapus lewat aplikasi.'], 403);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'User berhasil dihapus'], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus user'], 500);
        }
    }
}
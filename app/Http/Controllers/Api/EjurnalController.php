<?php

// Namespace controller API untuk Ejurnal
namespace App\Http\Controllers\Api;

// Memanggil Controller bawaan Laravel
use App\Http\Controllers\Controller;

// Request khusus untuk validasi saat tambah ejurnal
use App\Http\Requests\Ejurnal\StoreEjurnalRequest;

// Request khusus untuk validasi saat update ejurnal
use App\Http\Requests\Ejurnal\UpdateEjurnalRequest;

// Service yang berisi logika bisnis Ejurnal
use App\Services\EjurnalService;

// Request umum Laravel
use Illuminate\Http\Request;

// Controller untuk mengelola API Ejurnal
class EjurnalController extends Controller
{
    // Properti untuk menampung service ejurnal
    protected $ejurnalService;

    // Constructor: dijalankan saat controller pertama kali dipanggil
    public function __construct(EjurnalService $ejurnalService)
    {
        // Menyimpan service ke dalam properti agar bisa dipakai di semua method
        $this->ejurnalService = $ejurnalService;
    }

    // ===============================
    // MENAMPILKAN SEMUA DATA EJURNAL
    // ===============================
    public function index(Request $request)
    {
        try {
            // Mengambil jumlah data per halaman dari query (?per_page=10)
            // Jika tidak ada, default = 10
            $perPage = $request->input('per_page', 10);

            // Memanggil service untuk mengambil semua ejurnal (dengan pagination)
            $ejurnals = $this->ejurnalService->getAllEjurnals($perPage);

            // Mengembalikan response JSON jika berhasil
            return response()->json([
                'success' => true,
                'data' => $ejurnals
            ], 200);

        } catch (\Exception $e) {
            // Jika terjadi error, kirim response gagal
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch e-journals',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===============================
    // MENYIMPAN DATA EJURNAL BARU
    // ===============================
    public function store(StoreEjurnalRequest $request)
    {
        try {
            // Mengambil data yang sudah lolos validasi
            $validatedData = $request->validated();

            // Memanggil service untuk menyimpan ejurnal
            $ejurnal = $this->ejurnalService->createEjurnal($validatedData);

            // Response berhasil dibuat
            return response()->json([
                'success' => true,
                'message' => 'E-journal created successfully',
                'data' => $ejurnal
            ], 201);

        } catch (\Exception $e) {
            // Jika gagal menyimpan
            return response()->json([
                'success' => false,
                'message' => 'Failed to create e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===============================
    // MENAMPILKAN DETAIL EJURNAL
    // ===============================
    public function show($id)
    {
        try {
            // Mengambil ejurnal berdasarkan ID
            $ejurnal = $this->ejurnalService->getEjurnalById($id);

            // Response jika data ditemukan
            return response()->json([
                'success' => true,
                'data' => $ejurnal
            ], 200);

        } catch (\Exception $e) {
            // Jika data tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'E-journal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // ===============================
    // MENGUPDATE DATA EJURNAL
    // ===============================
    public function update(UpdateEjurnalRequest $request, $id)
    {
        try {
            // Mengambil data hasil validasi
            $validatedData = $request->validated();

            // Memanggil service untuk update ejurnal
            $ejurnal = $this->ejurnalService->updateEjurnal($id, $validatedData);

            // Response jika update berhasil
            return response()->json([
                'success' => true,
                'message' => 'E-journal updated successfully',
                'data' => $ejurnal
            ], 200);

        } catch (\Exception $e) {
            // Jika update gagal
            return response()->json([
                'success' => false,
                'message' => 'Failed to update e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===============================
    // MENGHAPUS DATA EJURNAL
    // ===============================
    public function destroy($id)
    {
        try {
            // Memanggil service untuk menghapus ejurnal berdasarkan ID
            $this->ejurnalService->deleteEjurnal($id);

            // Response jika berhasil dihapus
            return response()->json([
                'success' => true,
                'message' => 'E-journal deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            // Jika gagal menghapus
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===============================
    // MENGHAPUS GAMBAR EJURNAL SAJA
    // ===============================
    public function deleteGambar($id)
    {
        try {
            // Memanggil service untuk menghapus gambar ejurnal
            $this->ejurnalService->deleteGambarEjurnal($id);

            // Response jika gambar berhasil dihapus
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            // Jika gagal menghapus gambar
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

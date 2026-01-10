<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\BeritaService;

class BeritaController extends Controller
{
    protected $service;

    public function __construct(BeritaService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(
            Berita::with('user')->latest()->get()
        );
    }

    public function store(StoreBeritaRequest $request)
    {
        $berita = $this->service->store($request->validated());

        return response()->json([
            'message' => 'Berita berhasil ditambahkan',
            'data' => $berita
        ], 201);
    }

    public function show(Berita $berita)
    {
        $this->service->incrementView($berita);

        return response()->json(
            $berita->load('user')
        );
    }

    public function update(UpdateBeritaRequest $request, Berita $berita)
    {
        $berita = $this->service->update($berita, $request->validated());

        return response()->json([
            'message' => 'Berita berhasil diupdate',
            'data' => $berita
        ]);
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();

        return response()->json([
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}


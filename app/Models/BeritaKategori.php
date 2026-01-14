<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ===== BERITA KATEGORI =====
class BeritaKategori extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_berita_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_berita', 'id_kategori'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita', 'id_berita');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ===== KATEGORI MODEL =====
class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    public function beritas()
    {
        return $this->belongsToMany(
            Berita::class,
            'berita_kategoris',
            'id_kategori',
            'id_berita',
            'id_kategori',
            'id_berita'
        );
    }

    public function beritaKategoris()
    {
        return $this->hasMany(BeritaKategori::class, 'id_kategori', 'id_kategori');
    }
}

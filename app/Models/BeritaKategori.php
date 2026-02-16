<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BeritaKategori extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berita_kategoris'; 

    /**
     * Pivot ini pakai UUID
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'berita_id',
        'kategori_id',
    ];

    /**
     * Relasi ke Berita
     */
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
}

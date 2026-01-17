<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaKategori extends Model
{
    use HasFactory;

    protected $table = 'berita_kategoris';
    public $timestamps = false;

    protected $fillable = ['berita_id', 'kategori_id'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
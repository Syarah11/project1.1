<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',          // ← Dari 'nama_kategori'
        'slug',
        'description',   // ← Dari 'deskripsi'
    ];

    public function beritas()
    {
        return $this->belongsToMany(Berita::class, 'berita_kategoris');
    }
}
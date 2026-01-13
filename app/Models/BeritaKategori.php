<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaKategori extends Model
{
    protected $table = 'berita_kategoris';
    protected $primaryKey = 'id_berita_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_berita_kategori',
        'id_berita',
        'id_kategori'
    ];
}

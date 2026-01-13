<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BeritaKategori extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berita_kategoris';
    protected $primaryKey = 'id_berita_kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_berita',
        'id_kategori',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_berita_kategori)) {
                $model->id_berita_kategori = (string) Str::uuid();
            }
        });
    }
}
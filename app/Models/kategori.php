<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_kategori)) {
                $model->id_kategori = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
    }

    public function beritas()
    {
        return $this->belongsToMany(
            Berita::class,
            'berita_kategoris',
            'id_kategori',
            'id_berita'
        );
    }
}
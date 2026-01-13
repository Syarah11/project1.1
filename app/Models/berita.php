<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';
    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_berita',
        'id_user',
        'judul',
        'slug',
        'deskripsi',
        'thumbnail',
        'status',
        'view_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id_berita) {
                $model->id_berita = (string) Str::uuid();
            }

            if (! $model->slug) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kategoris()
    {
        return $this->belongsToMany(
            Kategori::class,
            'berita_kategoris',
            'id_berita',
            'id_kategori'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'berita_tags',
            'id_berita',
            'id_tag'
        );
    }
}

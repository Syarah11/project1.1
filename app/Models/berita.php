<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_berita';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'judul',
        'slug',
        'deskripsi',
        'thumbnail',
        'status',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
    ];

    // Relationships
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
            'id_kategori',
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
            'id_tag',
            'id_berita',
            'id_tag'
        );
    }

    public function beritaKategoris()
    {
        return $this->hasMany(BeritaKategori::class, 'id_berita', 'id_berita');
    }

    public function beritaTags()
    {
        return $this->hasMany(BeritaTag::class, 'id_berita', 'id_berita');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
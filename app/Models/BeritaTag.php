<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'status',
        'view_count',
    ];

    // ✅ TAMBAHKAN APPENDS
    protected $appends = ['thumbnail_url'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ GANTI DENGAN INI - Accessor untuk URL saja
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/default-thumbnail.jpg');
    }

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_kategoris');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'berita_tags');
    }
}

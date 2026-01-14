<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',       // ← Dari 'id_user'
        'title',         // ← Dari 'judul'
        'slug',
        'description',   // ← Dari 'deskripsi'
        'thumbnail',
        'status',
        'view_count',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_tag';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_tag',
        'slug',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function beritas()
    {
        return $this->belongsToMany(
            Berita::class,
            'berita_tags',
            'id_tag',
            'id_berita',
            'id_tag',
            'id_berita'
        );
    }

    public function beritaTags()
    {
        return $this->hasMany(BeritaTag::class, 'id_tag', 'id_tag');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',          // ← Dari 'nama_tag'
        'slug',
        'created_by',
    ];

    public function beritas()
    {
        return $this->belongsToMany(Berita::class, 'berita_tags');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
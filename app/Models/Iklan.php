<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',          // ← Dari 'nama'
        'thumbnail',
        'status',
        'link',
        'position',      // ← Dari 'posisi'
        'priority',      // ← Dari 'urutan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbnailAttribute($value)
    {
        return $value ?? asset('images/default-iklan-thumbnail.jpg');
    }
    
}
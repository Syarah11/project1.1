<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarEjurnal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ejurnal_id',
        'user_id',
        'image',
    ];

    protected $appends = ['image_url'];

    /**
     * Relasi ke Ejurnal
     */
    public function ejurnal()
    {
        return $this->belongsTo(Ejurnal::class);
    }

    /**
     * Relasi ke User (yang upload gambar)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : null;
    }
}
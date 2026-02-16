<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ejurnal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'status',
    ];

    protected $appends = ['thumbnail_url'];

    /**
     * Relasi ke User (pembuat ejurnal)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke GambarEjurnal (semua gambar ejurnal)
     */
    public function gambarEjurnals()
    {
        return $this->hasMany(GambarEjurnal::class, 'ejurnal_id');
    }

    /**
     * Relasi ke GambarEjurnal (gambar pertama sebagai thumbnail fallback)
     */
    public function firstGambar()
    {
        return $this->hasOne(GambarEjurnal::class, 'ejurnal_id')->oldest();
    }

    /**
     * Accessor untuk thumbnail URL
     * Priority: thumbnail terpisah > gambar pertama > null
     */
    public function getThumbnailUrlAttribute()
    {
        // Jika ada thumbnail terpisah, pakai itu
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Jika tidak ada, pakai gambar pertama dari gambar_ejurnals
        if ($this->firstGambar) {
            return asset('storage/' . $this->firstGambar->image);
        }
        
        // Jika tidak ada sama sekali
        return null;
    }
}
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
        'name',
        'thumbnail',
        'status',
        'link',
        'position',
        'priority',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // HAPUS getThumbnailAttribute() dari sini.
    // Accessor itu mengubah nilai 'thumbnail' saat diserialisasi ke JSON,
    // sehingga API mengembalikan full URL asset() bukan path asli dari storage.
    // Akibatnya di blade, logic penggabungan MEDIA + /storage/ + path jadi salah.
    //
    // Gunakan helper method terpisah jika butuh URL lengkap di Blade/API:

    /**
     * Kembalikan URL thumbnail lengkap untuk ditampilkan.
     * Gunakan ini di resource/API response jika perlu, bukan sebagai accessor.
     */
    public function getThumbnailUrl(): string
    {
        if (empty($this->thumbnail)) {
            return asset('images/default-iklan-thumbnail.jpg');
        }

        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return asset('storage/' . ltrim($this->thumbnail, '/'));
    }
}
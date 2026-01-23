<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ejurnal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
    ];

    protected $appends = ['thumbnail_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gambars()
    {
        return $this->hasMany(GambarEjurnal::class, 'ejurnal_id');
    }

    // ✅ RELASI THUMBNAIL (INI YANG KAMU BUTUHKAN)
    public function thumbnail()
    {
        return $this->hasOne(GambarEjurnal::class, 'ejurnal_id')
                    ->where('image', true);
    }

    // ✅ ACCESSOR URL
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail->image)
            : null;
    }
}


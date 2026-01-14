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
        'image',         // ← Dari 'gambar'
    ];

    public function ejurnal()
    {
        return $this->belongsTo(Ejurnal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
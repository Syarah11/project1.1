<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejurnal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',         // ← Dari 'judul'
        'description',   // ← Dari 'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gambarEjurnals()
    {
        return $this->hasMany(GambarEjurnal::class);
    }
}
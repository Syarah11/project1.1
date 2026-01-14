<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUuids;

    protected $fillable = [
        'name',        // ← Dari 'nama'
        'email',
        'password',
        'role',
        'thumbnail',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }

    public function ejurnals()
    {
        return $this->hasMany(Ejurnal::class);
    }

    public function gambarEjurnals()
    {
        return $this->hasMany(GambarEjurnal::class);
    }

    public function iklans()
    {
        return $this->hasMany(Iklan::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }
}
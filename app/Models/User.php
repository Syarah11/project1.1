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

    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
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
        return $this->hasMany(Berita::class, 'id_user', 'id_user');
    }

    public function ejurnals()
    {
        return $this->hasMany(Ejurnal::class, 'id_user', 'id_user');
    }

    public function gambarEjurnals()
    {
        return $this->hasMany(GambarEjurnal::class, 'id_user', 'id_user');
    }

    public function iklans()
    {
        return $this->hasMany(Iklan::class, 'id_user', 'id_user');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by', 'id_user');
    }
}
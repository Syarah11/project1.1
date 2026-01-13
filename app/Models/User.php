<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'thumbnail',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'id_user');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

    public function ejurnals()
    {
        return $this->hasMany(Ejurnal::class, 'id_user');
    }

    public function iklans()
    {
        return $this->hasMany(Iklan::class, 'id_user');
    }
}
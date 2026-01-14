<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_iklan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user', 'nama', 'thumbnail', 'link', 'status', 'posisi', 'urutan'
    ];

    protected $casts = ['urutan' => 'integer'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
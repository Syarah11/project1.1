<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    protected $table = 'iklans';
    protected $primaryKey = 'id_iklan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_iklan',
        'id_user',
        'nama',
        'thumbnail',
        'status',
        'link',
        'posisi',
        'urutan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

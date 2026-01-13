<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejurnal extends Model
{
    protected $table = 'ejurnals';
    protected $primaryKey = 'id_ejurnal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ejurnal',
        'id_user',
        'judul',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function gambarEjurnals()
    {
        return $this->hasMany(GambarEjurnal::class, 'id_ejurnal', 'id_ejurnal');
    }
}

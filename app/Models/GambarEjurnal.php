<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarEjurnal extends Model
{
    protected $table = 'gambar_ejurnals';
    protected $primaryKey = 'id_gambar_ejurnal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_gambar_ejurnal',
        'id_ejurnal',
        'id_user',
        'gambar'
    ];

    public function ejurnal()
    {
        return $this->belongsTo(Ejurnal::class, 'id_ejurnal', 'id_ejurnal');
    }
}

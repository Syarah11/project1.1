<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id_tag';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tag',
        'nama_tag',
        'slug',
        'created_by'
    ];

    public function beritas()
    {
        return $this->belongsToMany(
            Berita::class,
            'berita_tags',
            'id_tag',
            'id_berita'
        );
    }
}

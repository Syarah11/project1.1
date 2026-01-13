<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaTag extends Model
{
    protected $table = 'berita_tags';
    protected $primaryKey = 'id_berita_tag';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_berita_tag',
        'id_berita',
        'id_tag'
    ];
}

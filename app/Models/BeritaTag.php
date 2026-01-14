<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaTag extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_berita_tag';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_berita', 'id_tag'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'id_berita', 'id_berita');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag', 'id_tag');
    }
}
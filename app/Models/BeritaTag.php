<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaTag extends Model
{
    use HasFactory;

    protected $table = 'berita_tags';
    public $timestamps = false;

    protected $fillable = ['berita_id', 'tag_id'];

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
    
}
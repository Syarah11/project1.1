<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BeritaTag extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'berita_tags';
    protected $primaryKey = 'id_berita_tag';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_berita',
        'id_tag',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_berita_tag)) {
                $model->id_berita_tag = (string) Str::uuid();
            }
        });
    }
}
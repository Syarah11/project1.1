<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id_tag';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tag',
        'nama_tag',
        'slug',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id_tag) {
                $model->id_tag = (string) Str::uuid();
            }

            if (! $model->slug) {
                $model->slug = Str::slug($model->nama_tag);
            }
        });
    }
}

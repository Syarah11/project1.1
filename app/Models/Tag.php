<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tags';
    protected $primaryKey = 'id_tag';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama_tag',
        'slug',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_tag)) {
                $model->id_tag = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_tag);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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
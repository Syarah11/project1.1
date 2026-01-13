<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GambarEjurnal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'gambar_ejurnals';
    protected $primaryKey = 'id_gambar_ejurnal';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_ejurnal',
        'id_user',
        'gambar',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_gambar_ejurnal)) {
                $model->id_gambar_ejurnal = (string) Str::uuid();
            }
        });
    }

    public function ejurnal()
    {
        return $this->belongsTo(Ejurnal::class, 'id_ejurnal');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
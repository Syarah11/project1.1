<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ejurnal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ejurnals';
    protected $primaryKey = 'id_ejurnal';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'judul',
        'deskripsi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_ejurnal)) {
                $model->id_ejurnal = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function gambars()
    {
        return $this->hasMany(GambarEjurnal::class, 'id_ejurnal');
    }
}
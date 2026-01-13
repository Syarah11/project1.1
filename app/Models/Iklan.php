<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Iklan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'iklans';
    protected $primaryKey = 'id_iklan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama',
        'email',
        'thumbnail',
        'link',
        'status',
        'posisi',
        'urutan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_iklan)) {
                $model->id_iklan = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
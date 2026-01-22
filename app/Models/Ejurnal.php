<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ejurnal extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
    ];

    protected $appends = ['thumbnail'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gambars()
    {
        return $this->hasMany(GambarEjurnal::class, 'ejurnal_id');
    }

    public function getThumbnailAttribute()
    {
        return $this->gambars->first()
            ? asset('storage/' . $this->gambars->first()->image)
            : null;
    }
}

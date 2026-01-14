<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarEjurnal extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id_gambar_ejurnal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_ejurnal', 'id_user', 'gambar'];

    public function ejurnal()
    {
        return $this->belongsTo(Ejurnal::class, 'id_ejurnal', 'id_ejurnal');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

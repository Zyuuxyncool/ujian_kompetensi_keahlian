<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSeller extends Model
{
    use HasFactory;

    protected $table = 'profil_sellers';

    protected $fillable = [
        'user_id',
        'uuid',
        'photo',
        'nama',
        'notlp',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'latitude',
        'longitude',
        'radius',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipperSub extends Model
{
    use HasFactory;

    protected $table = 'sub_shippers';

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

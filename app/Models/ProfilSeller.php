<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSeller extends Model
{
    use HasFactory;
    const JENIS_USAHA = [
        1 => 'Perorangan',
        2 => 'Perusahaan (CV/PT)',
    ];
    const FLAG = [
        0 => 'Tidak Aktif',
        1 => 'Aktif',
    ];
    protected $table = 'profil_sellers';
    protected $fillable = [
        'user_id',
        'uuid',
        'photo',
        'nik',
        'nama',
        'nama_toko',
        'notlp',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'latitude',
        'longitude',
        'radius',
        'jenis_usaha',
        'flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJenisUsahaTextAttribute()
    {
        return self::JENIS_USAHA[$this->jenis_usaha] ?? '-';
    }

    public function getFlagTextAttribute()
    {
        return self::FLAG[$this->flag] ?? '-';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'profil_id', 'id');
    }
}

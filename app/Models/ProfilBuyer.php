<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilBuyer extends Model
{
    use HasFactory;

    protected $table = 'profil_buyers';

    protected $fillable = [
        'user_id',
        'uuid',
        'photo',
        'nama',
        'jenis_kelamin',
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

    public function getJenisKelaminCaptionAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getUsiaAttribute()
    {
        $dob = new \DateTime($this->tanggal_lahir);
        $today = new \DateTime();
        return $today->diff($dob)->y;
    }
}

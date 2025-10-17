<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    const LIST_TINGKAT = [1 => 'Provinsi', 2 => 'Kabupaten', 3 => 'Kecamatan', 4 => 'Kelurahan'];
    protected $table = 'lokasi';
}

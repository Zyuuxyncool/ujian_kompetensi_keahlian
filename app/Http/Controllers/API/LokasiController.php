<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index($parent_id = '0')
    {
        $lokasi = Lokasi::whereIn('parent_id', explode(',', $parent_id))->get();
        return response()->json($lokasi);
    }
}

<?php

namespace App\Services;

use App\Models\ProfilSeller;
use Illuminate\Support\Str;

class ProfilSellerService extends Service
{
    public function search($params = [])
    {
        $seller = ProfilSeller::orderBy('id');

        $seller = $this->searchFilter($params, $seller, []);
        return $this->searchResponse($params, $seller);
    }

    public function find($value, $column = 'id')
    {
        return ProfilSeller::where($column, $value)->first();
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return ProfilSeller::create($params);
    }

    public function update($id, $params)
    {
        $seller = ProfilSeller::find($id);
        if (!empty($seller)) $seller->update($params);
        return $seller;
    }

    public function delete($id)
    {
        $seller = ProfilSeller::find($id);
        if (!empty($seller)) {
            try {
                $seller->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
        return $seller;
    }

    public function getJenisUsaha()
    {
        return ProfilSeller::JENIS_USAHA;
    }

    public function getFlag()
    {
        return ProfilSeller::FLAG;
    }
}

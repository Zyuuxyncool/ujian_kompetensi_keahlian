<?php

namespace App\Services;

use App\Models\ProfilBuyer;
use Illuminate\Support\Str;

class ProfilBuyerService extends Service
{
    public function search($params = [])
    {
        $buyer = ProfilBuyer::orderBy('id');

        $buyer = $this->searchFilter($params, $buyer, []);
        return $this->searchResponse($params, $buyer);
    }

    public function find($value, $column = 'id')
    {
        return ProfilBuyer::where($column, $value)->first();
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return ProfilBuyer::create($params);
    }

    public function update($id, $params)
    {
        $buyer = ProfilBuyer::find($id);
        if (!empty($buyer)) $buyer->update($params);
        return $buyer;
    }

    public function delete($id)
    {
        $buyer = ProfilBuyer::find($id);
        if (!empty($buyer)) {
            try {
                $buyer->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
        return $buyer;
    }
}

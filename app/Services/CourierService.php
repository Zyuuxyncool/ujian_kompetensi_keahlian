<?php

namespace App\Services;

use App\Models\Courier;

class CourierService extends Service
{
    public function search($params = [])
    {
        $courier = Courier::orderby('id');

        $courier = $this->searchFilter($params, $courier, []);
        return $this->searchResponse($params, $courier);
    }

    public function find($value, $column = 'id')
    {
        return Courier::where($column, $value)->first();
    }

    public function store($params)
    {
        return Courier::create($params);
    }

    public function update($id, $params)
    {
        $courier = Courier::find($id);
        if (!empty($courier)) $courier->update($params);
        return $courier;
    }

    public function delete($id)
    {
        $courier = Courier::find($id);
        if (!empty($courier)) {
            try {
                $courier->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
        return $courier;
    }
}

<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Str;

class BrandService extends Service
{
    public function search($params = [])
    {
        $brand = Brand::orderBy('id');

        $brand = $this->searchFilter($params, $brand, []);
        return $this->searchResponse($params, $brand);
    }

    public function find($value, $column = 'id')
    {
        return Brand::where($column, $value)->first();
    }

    public function update($params, $id)
    {
        $brand = Brand::find($id);
        if (!empty($brand)) $brand->update($params);
        return $brand;
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return Brand::create($params);
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if (!empty($brand)) {
            try {
                $brand->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
    }
}

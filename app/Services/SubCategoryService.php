<?php

namespace App\Services;
use App\Models\SubCategory;

class SubCategoryService extends Service
{
    public function search($params)
    {
        $query = SubCategory::query();

        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        return $query->paginate(10);
    }

    public function store($data)
    {
        return SubCategory::create($data);
    }

    public function find($id)
    {
        return SubCategory::findOrFail($id);
    }

    public function update($params, $id)
    {
        $subCategory = SubCategory::find($id);
        if (!empty($subCategory)) $subCategory->update($params);
        return $subCategory;
    }

    public function delete($id)
    {
        $subCategory = SubCategory::find($id);
        if ($subCategory) {
            try {
                $subCategory->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete sub-category failed! This sub-category is currently being used'];  
            }
        }
    }
}
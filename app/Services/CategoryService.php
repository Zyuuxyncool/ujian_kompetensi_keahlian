<?php

namespace App\Services;
use App\Models\Category;

class CategoryService extends Service
{
    public function search($params)
    {
        $query = Category::query();

        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        return $query->paginate(10);
    }

    public function store($data)
    {
        return Category::create($data);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function update($params, $id)
    {
        $category = Category::find($id);
        if (!empty($category)) $category->update($params);
        return $category;
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {
            try {
                $category->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete category failed! This category is currently being used'];  
            }
        }
    }
}

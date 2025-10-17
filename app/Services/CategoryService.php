<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService extends Service
{
    public function search($params)
    {
        $category = Category::orderBy('id');
        $category = $this->searchFilter($params, $category, ['name']);
        return $this->searchResponse($params, $category);
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return Category::create($params);
    }

    public function find($value, $column = 'id')
    {
        return Category::where($column, $value)->first();
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

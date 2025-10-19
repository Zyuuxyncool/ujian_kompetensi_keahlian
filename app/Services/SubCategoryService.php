<?php

namespace App\Services;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubCategoryService extends Service
{
    public function search($params)
    {
        $category_sub = SubCategory::orderBy('id');

        $category_id = $params['category_id'] ?? '';
        if ($category_id !== '') $category_sub = $category_sub->whereHas('category', fn($list_cetegory) => $list_cetegory->where('id', $category_id));

        $category_sub = $this->searchFilter($params, $category_sub, ['name']);
        return $this->searchResponse($params, $category_sub);
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return SubCategory::create($params);
    }

    public function find($id)
    {
        return SubCategory::findOrFail($id);
    }

    public function update($params, $id)
    {
        $category_sub = SubCategory::find($id);
        if (!empty($category_sub)) $category_sub->update($params);
        return $category_sub;
    }

    public function delete($id)
    {
        $category_sub = SubCategory::find($id);
        if ($category_sub) {
            try {
                $category_sub->delete();
                return true;
            } catch (\Throwable $e) {
                return ['error' => 'Delete sub-category failed! This sub-category is currently being used'];
            }
        }
    }

    public function list_category()
    {
        return Category::orderBy('name', 'asc')->pluck('name', 'id')->toArray();
    }

    public function list()
    {
        return SubCategory::orderBy('name')->pluck('name', 'id')->toArray();
    }
}

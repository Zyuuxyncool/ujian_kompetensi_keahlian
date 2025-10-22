<?php

namespace App\Services;

use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductImageService extends Service
{
    public function search($params = [])
    {
        $product = ProductImage::orderBy('id');

        $product = $this->searchFilter($params, $product, ['product_id']);
        return $this->searchResponse($params, $product);
    }

    public function find($value, $column = 'id')
    {
        return ProductImage::where($column, $value)->first();
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return ProductImage::create($params);
    }

    public function update($id, $params)
    {
        $product = ProductImage::find($id);
        if (!empty($product)) $product->update($params);
        return $product;
    }

    public function delete($id)
    {
        $product = ProductImage::find($id);
        if (!empty($product)) {
            try {
                $product->delete();
                return true;
            } catch (\Exception $e) {
                return ['error' => 'Delete user failed! This user currently being used'];
            }
        }
        return $product;
    }

    public function deleteByProductId($productId)
    {
        return ProductImage::where('product_id', $productId)->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService extends Service
{
    public function search($params = [])
    {
        $product = Product::orderBy('id');
        if (isset($params['q']) && $params['q'] !== '') {
            $query = $params['q'];
            $product = $product->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
            unset($params['q']);
        }
        $product = $this->searchFilter($params, $product, ['profil_id', 'name']);
        return $this->searchResponse($params, $product);
    }

    public function find($value, $column = 'id')
    {
        return Product::where($column, $value)->first();
    }

    public function store($params)
    {
        $params['uuid'] = Str::uuid();
        return Product::create($params);
    }

    public function update($id, $params)
    {
        $product = Product::find($id);
        if (!empty($product)) $product->update($params);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::find($id);
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

    public function autocompleteSearch(string $query)
    {
        // Cari produk yang namanya mengandung $query
        return Product::where('name', 'LIKE', "%{$query}%")
            // Ambil hanya kolom 'id' dan 'name'
            ->select('id', 'name')
            // Batasi hasilnya
            ->limit(10)
            ->get();
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Builder; 

class ProductService extends Service
{
    public function search($params = [])
    {
        if (isset($params['q']) && $params['q'] !== '') {
            $query = $params['q'];
            $product = Product::search($query);
            unset($params['q']);
            unset($params['orders']);
            $excluded_columns = ['page', 'limit', 'skip']; 

            foreach ($params as $key => $value) {
                if ($value !== '' && !in_array($key, $excluded_columns)) {
                    if ($key == 'profil_id') {
                        $product->where($key, $value);
                    }
                }
            }
            
            $limit = $params['limit'] ?? null;
            $skip = $params['skip'] ?? null;
            
            if ($limit || $skip) {
                if ($limit) {
                    $product->take($limit);
                }
                
                $product = $product->get();
            }
            return $this->searchResponse($params, $product);

        } else {
            $product = Product::query()->orderBy('id');
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
        if (!empty($product)) $product->update($params);
        $product = Product::find($id);
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
        return Product::search($query)->take(10)->get(); 
    }
}

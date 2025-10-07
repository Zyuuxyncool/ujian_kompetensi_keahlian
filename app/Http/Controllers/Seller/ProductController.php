<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        return view('seller.products.index');
    }

    public function search(Request $request)
    {
        $products = $this->productService->search($request->all());
        return view('seller.products._table', compact('products'));
    }

    public function create()
    {
        return view('seller.products._form');
    }

    public function store(Request $request)
    {
        return $this->productService->store($request->all());
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        return view('seller.products._form', compact('product'));
    }

    public function update(Request $request, $id)
    {
        return $this->productService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->productService->delete($id);
    }
}
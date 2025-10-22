<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Services\ProductImageService;
use App\Services\DocumentService;
use App\Services\BrandService;
use App\Services\SubCategoryService;
use App\Services\ProfilSellerService;

class ProductController extends Controller
{
    protected $productService, $profilSellerService, $productImageService, $brandService, $subCategoryService;
    public function __construct()
    {
        $this->profilSellerService = new ProfilSellerService();
        $this->productImageService = new ProductImageService();
        $this->productService = new ProductService();
        $this->brandService = new BrandService();
        $this->subCategoryService = new SubCategoryService();
        view()->share(['list_brands' => $this->brandService->list(), 'list_sub_categories' => $this->subCategoryService->list()]);
    }

    public function index()
    {
        return view('seller.products.index');
    }

    public function search(Request $request)
    {
        $profil = $this->profilSellerService->find(auth()->id(), 'user_id');
        $request->merge(['profil_id' => $profil->id]);
        $products = $this->productService->search($request->all());
        return view('seller.products._table', compact('products'));
    }

    public function create()
    {
        return view('seller.products._form');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $profil = $this->profilSellerService->find($user->id, 'user_id');

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|string',
            'stock'       => 'required|integer|min:1',
            'sub_category_id' => 'nullable|integer|exists:sub_categories,id',
            'brand_id'        => 'nullable|integer|exists:brands,id',
            'images'          => 'nullable|array',
            'images.*'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'stock.required' => 'Stok produk wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg.',
            'images.*.max'   => 'Ukuran gambar tidak boleh melebihi 2MB.',
        ]);

        $price = str_replace(['.', ','], ['', '.'], $request->price);

        $product = $this->productService->store([
            'profil_id'       => $profil->id,
            'name'            => $request->name,
            'description'     => $request->description,
            'price'           => $price,
            'stock'           => $request->stock,
            'sub_category_id' => $request->sub_category_id,
            'brand_id'        => $request->brand_id,
        ]);

        if ($request->hasFile('images')) {
            $files = DocumentService::save_multiple_file($request, 'images', 'public/images/products');
            foreach ($files as $path) {
                $this->productImageService->store([
                    'product_id' => $product->id,
                    'photo' => $path,
                ]);
            }
        }

        return $product;
    }


    public function edit($id)
    {
        $product = $this->productService->find($id);
        return view('seller.products._form', compact('product'));
    }


    public function update(Request $request, $id)
    {
        $product = $this->productService->find($id);
        $price = str_replace(['.', ','], ['', '.'], $request->price);
        $this->productService->update($id, [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $price,
            'stock' => $request->stock,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
        ]);

        $existing_ids = $request->input('existing_ids', []); 
        $oldImages = $this->productImageService->search(['product_id' => $id]);
        foreach ($oldImages as $image) {
            if (!in_array($image->id, $existing_ids)) {
                DocumentService::delete_file($image->photo);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            $files = DocumentService::save_multiple_file($request, 'images', 'public/images/products');
            foreach ($files as $path) {
                $this->productImageService->store([
                    'product_id' => $id,
                    'photo' => $path,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        return $this->productService->delete($id);
    }
}

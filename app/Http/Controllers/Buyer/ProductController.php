<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\ProductImageService;
use App\Services\ProfilSellerService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection; 

class ProductController extends Controller
{
    protected $productService, $productImageService, $profilSellerService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->productImageService = new ProductImageService();
        $this->profilSellerService = new ProfilSellerService();
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('term');
        if (empty($query)) {
            return response()->json([]);
        }
        $products = $this->productService->autocompleteSearch($query);
        $formatted_results = $products->map(function ($product) {
            return [
                'id'    => $product->id,
                'label' => $product->name,
                'value' => $product->name
            ];
        });

        return response()->json($formatted_results);
    }

    public function searchResults(Request $request)
    {
        $query = $request->query('q');

        if (empty($query)) {
            return redirect()->back()->with('error', 'Silakan masukkan kata kunci pencarian.');
        }

        // --- PENCARIAN PRODUK ---
        $params = [
            'q' => $query,
            'orders' => ['name' => 'asc'], 
            'limit' => 100, 
        ];

        $results = $this->productService->search($params);
        if (!$results instanceof Collection) {
            $results = collect($results);
        }
        $result_count = $results->count();
        $productIds = $results->pluck('id')->toArray();
        $productImagesData = $this->productImageService->search([
            'product_id' => $productIds, 
            'limit' => 999
        ]);
        
        $productImages = collect($productImagesData)->groupBy('product_id');

        $results = $results->map(function ($product) use ($productImages) {
            // Menghubungkan gambar pertama
            $product->first_image = $productImages->get($product->id)?->first();
            
            // NOTE: Kami akan mengabaikan relasi profil seller pada produk di controller ini
            // karena kita mencari toko terkait secara terpisah di bawah.
            return $product;
        });

        // --- PENCARIAN TOKO TERKAIT ---
        // Mencari 1 toko yang namanya atau username-nya cocok dengan query pencarian
        $relatedStores = $this->profilSellerService->searchByName($query, 1);
        $related_store = $relatedStores->first();
        // -----------------------------

        return view('buyer.search.results', [
            'query' => $query,
            'results' => $results,
            'result_count' => $result_count,
            'related_store' => $related_store, // Kirim data toko terkait ke view
        ]);
    }

    // Method index tetap memanggil searchResults
    public function index(Request $request)
    {
        return $this->searchResults($request);
    }
}

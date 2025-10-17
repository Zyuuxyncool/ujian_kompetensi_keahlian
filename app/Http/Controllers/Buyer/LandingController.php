<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    protected $categoryService;
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }
    public function index(Request $request)
    {
        $category = $this->categoryService->search($request->all());

        return view('buyer.landing.index', compact('category'));
    }

    public function showCategory(Request $request, $uuid)
    {
        $category = $this->categoryService->find($uuid, 'uuid');
        $breadcrumbs = [['route' => 'buyer.landing','caption' => 'Buyer'],['route' => 'buyer.landing','caption' => 'Kategori'],['route' => 'buyer.landing.category.show','params' => ['uuid' => $category->uuid],'caption' => $category->name ]];
        return view('buyer.landing.category.index', compact('category', 'breadcrumbs'));
    }
}

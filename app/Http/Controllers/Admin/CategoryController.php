<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        return view('admin.categories.index');
    }

    public function search(Request $request)
    {
        $categories = $this->categoryService->search($request->all());
        return view('admin.categories._table', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories._form');
    }

    public function store(Request $request)
    {
        return $this->categoryService->store($request->all());
    }

    public function edit($id)
    {
        $category = $this->categoryService->find($id);
        return view('admin.categories._form', compact('category'));
    }

    public function update(Request $request, $id)
    {
        return $this->categoryService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->categoryService->delete($id);
    }
}
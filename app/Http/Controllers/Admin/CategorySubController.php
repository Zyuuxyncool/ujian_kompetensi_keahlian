<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubCategoryService;
use App\Services\DocumentService;
use Illuminate\Http\Request;

class CategorySubController extends Controller
{
    protected $categorySubService;
    public function __construct()
    {
        $this->categorySubService = new SubCategoryService();
        view()->share(['list_category' => $this->categorySubService->list_category()]);
    }

    public function index()
    {

        return view('admin.category_sub.index');
    }

    public function search(Request $request)
    {
        $filename = DocumentService::save_file($request, 'file_photo', 'public/images/category_sub');
        if ($filename !== '') $request->merge(['photo' => $filename]);
        $category_subs = $this->categorySubService->search($request->all());
        return view('admin.category_sub._table', compact('category_subs'));
    }

    public function create()
    {
        return view('admin.category_sub._form');
    }

    public function store(Request $request)
    {
        $filename = DocumentService::save_file($request, 'file_photo', 'public/images/category_sub');
        if ($filename !== '') $request->merge(['photo' => $filename]);
        return $this->categorySubService->store($request->all());
    }

    public function edit($id)
    {
        $category_sub = $this->categorySubService->find($id);
        return view('admin.category_sub._form', compact('category_sub'));
    }

    public function update(Request $request, $id)
    {
        return $this->categorySubService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->categorySubService->delete($id);
    }
}

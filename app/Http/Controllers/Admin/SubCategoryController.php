<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategoryService;
    public function __construct()
    {
        $this->subCategoryService = new SubCategoryService();
    }

    public function index()
    {
        return view('admin.subcategories.index');
    }

    public function search(Request $request)
    {
        $subCategories = $this->subCategoryService->search($request->all());
        return view('admin.subcategories._table', compact('subCategories'));
    }

    public function create()
    {
        return view('admin.subcategories._form');
    }

    public function store(Request $request)
    {
        return $this->subCategoryService->store($request->all());
    }

    public function edit($id)
    {
        $subCategory = $this->subCategoryService->find($id);
        return view('admin.subcategories._form', compact('subCategory'));
    }

    public function update(Request $request, $id)
    {
        return $this->subCategoryService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->subCategoryService->delete($id);
    }
}
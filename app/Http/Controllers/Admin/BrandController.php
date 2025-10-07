<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct()
    {
        $this->brandService = new BrandService();
    }

    public function index()
    {
        return view('admin.brands.index');
    }

    public function search(Request $request)
    {
        $brands = $this->brandService->search($request->all());
        return view('admin.brands._table', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands._form');
    }

    public function store(Request $request)
    {
        return $this->brandService->store($request->all());
    }

    public function edit($id)
    {
        $brand = $this->brandService->find($id);
        return view('admin.brands._form', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        return $this->brandService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->brandService->delete($id);
    }
}
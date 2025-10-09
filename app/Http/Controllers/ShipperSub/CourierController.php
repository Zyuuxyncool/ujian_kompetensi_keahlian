<?php

namespace App\Http\Controllers\ShipperSub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    protected $courierService;
    public function __construct()
    {
        
    }

    public function index()
    {
        return view('shipper_sub.courier.index');
    }

    public function search(Request $request)
    {
        return view('shipper_sub.courier._table');
    }

    public function create()
    {
        return view('shipper_sub.courier._form');
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {
        return view('shipper_sub.courier._form');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        
    }
}
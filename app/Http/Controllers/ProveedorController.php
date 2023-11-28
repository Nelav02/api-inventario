<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    
    public function index()
    {
        return Proveedor::all();
    }

    public function store(Request $request)
    {
        $proveedor = Proveedor::create($request->all());
        return response()->json($proveedor, 201);
    }

    public function show(string $id)
    {
        return $proveedor;
    }

    public function update(Request $request, string $id)
    {
        $proveedor->update($request->all());
        return response()->json($proveedor, 200);
    }

    public function destroy(string $id)
    {
        $proveedor->delete();
        return response()->json(null, 204);
    }
}

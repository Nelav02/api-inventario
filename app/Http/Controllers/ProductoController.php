<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function show(string $id)
    {
        return $producto;
    }

    public function update(Request $request, string $id)
    {
        $producto->update($request->all());
        return response()->json($producto, 200);
    }

    public function destroy(string $id)
    {
        $producto->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = $request->input('nombre');
        $producto->stock = $request->input('stock');
        $producto->fechaVencimiento = $request->input('fechaVencimiento');
        $producto->precio = $request->input('precio');
        $producto->proveedores_id = $request->input('proveedores_id');
        $producto->categorias_id = $request->input('categorias_id');

        $producto->save();
        return response()->json(['mensaje' => 'Producto registrado con éxito'], 201);
    }

    public function show(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }
        return response()->json([$producto], 200);
    }

    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }
        $producto->nombre = $request->input('nombre');
        $producto->stock = $request->input('stock');
        $producto->fechaVencimiento = $request->input('fechaVencimiento');
        $producto->precio = $request->input('precio');
        $producto->proveedores_id = $request->input('proveedores_id');
        $producto->categorias_id = $request->input('categorias_id');
        $producto->save();

        return response()->json(['mensaje' => 'Producto actualizado con éxito'], 200);
    }

    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['mensaje' => 'Producto no encontrado'], 404);
        }

        $producto->delete();
        return response()->json(['mensaje' => 'Producto eliminado con éxito'], 200);
    }
}

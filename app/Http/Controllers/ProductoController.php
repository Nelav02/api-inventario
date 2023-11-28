<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Models\Categoria;
use Carbon\Carbon;

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

    public function verStock($identificador)
    {
        $producto = Producto::find($identificador);

        if (!$producto) {
            $productos = Producto::where('nombre', 'like', '%' . $identificador . '%')->get();

            if ($productos->isEmpty()) {
                return response()->json(['mensaje' => 'Productos no encontrados'], 404);
            }

            $respuesta = $productos->map(function ($producto) {
                return ['nombre' => $producto->nombre, 'stock' => $producto->stock];
            });

            return response()->json($respuesta, 200);
        }

        return response()->json(['nombre' => $producto->nombre, 'stock' => $producto->stock], 200);
    }

    public function productosPorVencer(Request $request)
    {
        $diasAproxVencimiento = $request->input('dias_aprox_vencimiento', 7);
        $fechaActual = Carbon::now();
        $fechaLimite = $fechaActual->copy()->addDays($diasAproxVencimiento);

        $productosPorVencer = Producto::where('fechaVencimiento', '>', $fechaActual)
            ->where('fechaVencimiento', '<=', $fechaLimite)
            ->get();

        if ($productosPorVencer->isEmpty()) {
            return response()->json(['mensaje' => "No hay productos por vencer en los próximos $diasAproxVencimiento días"], 404);
        }

        $respuesta = $productosPorVencer->map(function ($producto) {
            return ['nombre' => $producto->nombre, 'fechaVencimiento' => $producto->fechaVencimiento];
        });

        return response()->json($respuesta, 200);
    }

    public function productosPorCategoria($nombreCategoria)
    {
        try {
            $categoria = Categoria::where('nombre', $nombreCategoria)->firstOrFail();
    
            $productos = Producto::where('categorias_id', $categoria->id)->get();
    
            if ($productos->isEmpty()) {
                return response()->json(['mensaje' => 'No hay productos disponibles para esta categoría'], 404);
            }
    
            return response()->json(['productos' => $productos], 200);

        } catch (ModelNotFoundException $exception) {
            return response()->json(['mensaje' => 'Categoría no encontrada'], 404);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\VentaController;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;


class VentaController extends Controller
{

    public function index()
    {
        return Venta::all();
    }

    public function store(Request $request)
    {
         // Obtiene el producto
         $producto = Producto::findOrFail($request->input('producto_id'));

         // Verifica si hay suficiente stock
         if ($producto->stock < $request->input('cantidad')) {
             return response()->json(['mensaje' => 'Stock no disponible'], 400);
         }
 
         // Calcula el precio total de la venta
         $precioTotal = $request->input('cantidad') * $producto->precio;
 
         // Crea una nueva venta
         $venta = Venta::create([
             'producto_id' => $request->input('producto_id'),
             'cliente_id' => $request->input('cliente_id'),
             'cantidad' => $request->input('cantidad'),
             'precio' => $precioTotal,
         ]);
 
         // Disminuye el stock del producto
         $producto->decrement('stock', $request->input('cantidad'));
 
         // Devuelve la respuesta
         return response()->json(['mensaje' => 'Venta registrada con éxito', 'venta' => $venta], 201);
    }

    public function show(string $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrado'], 404);
        }
        return response()->json([$venta], 200);
    }

    public function destroy(string $id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['mensaje' => 'Venta no encontrado'], 404);
        }

        $venta->delete();
        return response()->json(['mensaje' => 'Venta eliminado con éxito'], 200);
    }

    public function verFactura($identificador = null)
    {
        $query = DB::table('ventas AS v')
        ->select('v.id AS Num_Factura', 'c.nombre AS Nombre_Cliente', 'p.nombre AS Nombre_Producto', 'v.cantidad', 'v.precio')
        ->join('clientes AS c', 'v.cliente_id', '=', 'c.id')
        ->join('productos AS p', 'v.producto_id', '=', 'p.id');

        if ($identificador !== null) {
            $query->where('v.id', $identificador)
                ->orWhere('c.nombre', 'like', '%' . $identificador . '%');
        }

        $facturas = $query->get();

        if ($facturas->isEmpty()) {
            return response()->json(['mensaje' => 'No hay facturas disponibles'], 404);
        }

        return response()->json(['facturas' => $facturas], 200);
    }

    public function verXanio($anio = null)
    {     
        $query = Venta::query();
    if ($anio) {
        $query->whereYear('created_at', $anio);
    }

    // Obtener las facturas
    $facturas = $query->get();

    if ($facturas->isEmpty()) {
        return response()->json(['mensaje' => 'No hay facturas disponibles para el año proporcionado'], 404);
    }

    return response()->json(['facturas' => $facturas], 200);
    }
}
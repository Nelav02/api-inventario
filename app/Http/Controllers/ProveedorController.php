<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProveedorController;
use Illuminate\Http\Request;
use App\Models\Proveedor;


class ProveedorController extends Controller
{
    
    public function index()
    {
        return Proveedor::all();
    }

    public function store(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->nombre = $request->input('nombre');
        $proveedor->lugar = $request->input('lugar');
        $proveedor->save();
        return response()->json(['mensaje' => 'Proveedor registrado con éxito'], 201);
    }

    public function show(string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }
        return response()->json([$proveedor], 200);
    }

    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }

        $proveedor->nombre = $request->input('nombre');
        $proveedor->lugar = $request->input('lugar');
        $proveedor->save();

        return response()->json(['mensaje' => 'Proveedor actualizado con éxito'], 200);
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['mensaje' => 'Proveedor no encontrado'], 404);
        }

        $proveedor->delete();
        return response()->json(['mensaje' => 'Proveedor eliminado con éxito'], 200);
    }
}

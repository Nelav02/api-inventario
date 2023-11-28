<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CategoriaController;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    public function index()
    {
        return Categoria::all();
    }

    public function store(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->input('nombre');
        $categoria->save();
        return response()->json(['mensaje' => 'Categoria registrado con éxito'], 201);
    }

    public function show(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoria no encontrado'], 404);
        }

        return response()->json([$categoria], 200);
    }

    public function update(Request $request, string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoria no encontrado'], 404);
        }

        $categoria->nombre = $request->input('nombre');
        $categoria->save();

        return response()->json(['mensaje' => 'Categoria actualizado con éxito'], 200);
    }

    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['mensaje' => 'Categoria no encontrado'], 404);
        }

        $categoria->delete();
        return response()->json(['mensaje' => 'Categoria eliminado con éxito'], 200);
    }
}
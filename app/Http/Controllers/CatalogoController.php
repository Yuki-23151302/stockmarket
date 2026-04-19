<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        // Iniciar consulta
        $query = Producto::query();

        // 🔍 Filtro por nombre (opcional)
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // 🔍 Filtro por categoría (opcional, si tienes categorias)
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Obtener productos
        $productos = $query->get();

        // Retornar vista
        return view('catalogo.index', compact('productos'));
    }
}
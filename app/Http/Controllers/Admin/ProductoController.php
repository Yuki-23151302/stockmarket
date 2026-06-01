<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // ── Listar todos los productos ───────────────────
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        $query = Producto::with('categoria');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        $productos = $query->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    // ── Formulario para crear ────────────────────────
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.form', compact('categorias'));
    }

    // ── Guardar nuevo producto ───────────────────────
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $nombreArchivo = $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('images/productos'), $nombreArchivo);
            $datos['imagen'] = 'images/productos/' . $nombreArchivo;
        }

        Producto::create($datos);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    // ── Formulario para editar ───────────────────────
    public function edit($id)
    {
        $producto   = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.form', compact('producto', 'categorias'));
    }

    // ── Actualizar producto ──────────────────────────
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                unlink(public_path($producto->imagen));
            }
            $nombreArchivo = $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('images/productos'), $nombreArchivo);
            $datos['imagen'] = 'images/productos/' . $nombreArchivo;
        }

        $producto->update($datos);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    // ── Eliminar producto ────────────────────────────
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagen && file_exists(public_path($producto->imagen))) {
            unlink(public_path($producto->imagen));
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
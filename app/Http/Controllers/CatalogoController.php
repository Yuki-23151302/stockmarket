?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        // Construir query con filtros opcionales
        $query = Producto::with('categoria')->where('stock', '>', 0);

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Buscador por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $productos = $query->get();

        return view('cliente.catalogo', compact('productos', 'categorias'));
    }
}

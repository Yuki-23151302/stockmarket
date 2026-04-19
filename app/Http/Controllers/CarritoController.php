<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoDetalle;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    // Ver carrito
    public function index()
    {
        $carrito = $this->obtenerOCrearCarrito();
        $detalles = $carrito->carritoDetalles()->with('producto')->get();
        $total = $detalles->sum('subtotal');

        return view('cliente.carrito', compact('detalles', 'total'));
    }

    // Agregar producto
    public function agregar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $carrito = $this->obtenerOCrearCarrito();

        $detalle = $carrito->carritoDetalles()
            ->where('producto_id', $producto->id)
            ->first();

        if ($detalle) {
            $detalle->cantidad += $request->cantidad;
            $detalle->subtotal = $detalle->cantidad * $producto->precio;
            $detalle->save();
        } else {
            $carrito->carritoDetalles()->create([
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'subtotal' => $producto->precio * $request->cantidad,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad
    public function actualizar(Request $request)
    {
        $request->validate([
            'detalle_id' => 'required|exists:carrito_detalles,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $detalle = CarritoDetalle::findOrFail($request->detalle_id);
        $detalle->cantidad = $request->cantidad;
        $detalle->subtotal = $detalle->cantidad * $detalle->producto->precio;
        $detalle->save();

        return redirect()->route('carrito')->with('success', 'Cantidad actualizada');
    }

    // Eliminar producto
    public function eliminar($id)
    {
        CarritoDetalle::findOrFail($id)->delete();
        return redirect()->route('carrito')->with('success', 'Producto eliminado');
    }

    // Finalizar compra
    public function finalizar()
    {
        $carrito = $this->obtenerOCrearCarrito();
        $detalles = $carrito->carritoDetalles()->with('producto')->get();

        if ($detalles->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'Carrito vacío');
        }

        DB::transaction(function () use ($detalles, $carrito) {

            $total = $detalles->sum('subtotal');

            $venta = Venta::create([
                'user_id' => auth()->id(),
                'fecha_venta' => now(),
                'total' => $total,
                'descuento' => 0
            ]);

            foreach ($detalles as $detalle) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->producto->precio,
                ]);

                // descontar stock
                $detalle->producto->decrement('stock', $detalle->cantidad);
            }

            // limpiar carrito
            $carrito->carritoDetalles()->delete();
        });

        return redirect()->route('pedidos')->with('success', 'Compra realizada');
    }

    // Helper
    private function obtenerOCrearCarrito()
    {
        return Carrito::firstOrCreate(
            ['user_id' => auth()->id()],
            ['fecha_creacion' => now()]
        );
    }
}
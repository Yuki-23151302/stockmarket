<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoDetalle extends Model
{
    protected $fillable = [
        'carrito_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
}

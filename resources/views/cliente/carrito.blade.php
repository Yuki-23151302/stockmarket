@extends('layouts.app')

@section('title', 'Carrito de Compras')

@push('styles')
<style>
    .page-header {
        background: #fff;
        border-bottom: 1px solid var(--gris-borde);
        padding: 20px 0;
        margin-bottom: 0;
    }
    .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: var(--azul);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-header h1 i { color: var(--naranja); }

    .layout-carrito {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    /* ── Tarjeta base ────────────────────────── */
    .card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        overflow: hidden;
    }
    .card-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gris-borde);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-head h2 {
        font-size: 15px;
        font-weight: 700;
        color: var(--azul);
    }
    .card-head .badge {
        background: var(--azul-light);
        color: var(--azul);
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* ── Ítems del carrito ───────────────────── */
    .cart-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--gris-borde);
        transition: background .15s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: #fafbfc; }

    .item-img {
        width: 64px; height: 64px;
        border-radius: 10px;
        background: #f0f4f8;
        display: flex; align-items: center; justify-content: center;
        color: #cbd5e0;
        font-size: 24px;
        flex-shrink: 0;
        overflow: hidden;
    }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }

    .item-info { flex: 1; min-width: 0; }
    .item-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--texto);
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .item-price {
        font-size: 13px;
        color: var(--texto-sub);
    }

    /* Controles de cantidad */
    .qty-control {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid var(--gris-borde);
        border-radius: 8px;
        overflow: hidden;
    }
    .qty-btn {
        width: 32px; height: 32px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: var(--texto-sub);
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
        font-family: 'Nunito', sans-serif;
    }
    .qty-btn:hover { background: #f4f6f9; color: var(--azul); }
    .qty-input {
        width: 40px;
        text-align: center;
        border: none;
        border-left: 1px solid var(--gris-borde);
        border-right: 1px solid var(--gris-borde);
        font-size: 14px;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        color: var(--texto);
        background: none;
        padding: 0;
        height: 32px;
        outline: none;
    }

    .item-subtotal {
        font-size: 15px;
        font-weight: 800;
        color: var(--azul);
        min-width: 70px;
        text-align: right;
    }

    .btn-delete {
        width: 34px; height: 34px;
        background: #fff0f0;
        border: none;
        border-radius: 8px;
        color: #ef4444;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        transition: background .15s;
    }
    .btn-delete:hover { background: #fee2e2; }

    /* ── Resumen ─────────────────────────────── */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        font-size: 14px;
        border-bottom: 1px solid var(--gris-borde);
    }
    .summary-row .label { color: var(--texto-sub); font-weight: 600; }
    .summary-row .value { font-weight: 700; color: var(--texto); }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-top: 2px solid var(--gris-borde);
    }
    .summary-total .label {
        font-size: 15px;
        font-weight: 700;
        color: var(--texto);
    }
    .summary-total .value {
        font-size: 24px;
        font-weight: 800;
        color: var(--azul);
    }

    .summary-actions { padding: 16px 20px; display: flex; flex-direction: column; gap: 10px; }

    .btn-checkout {
        width: 100%;
        padding: 14px;
        background: var(--naranja);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        cursor: pointer;
        transition: background .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-checkout:hover { background: var(--naranja-dk); }

    .btn-continue {
        width: 100%;
        padding: 12px;
        background: none;
        color: var(--azul);
        border: 2px solid var(--gris-borde);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        text-align: center;
        text-decoration: none;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-continue:hover { background: var(--azul-light); border-color: var(--azul); }

    /* ── Carrito vacío ───────────────────────── */
    .empty-cart {
        padding: 64px 20px;
        text-align: center;
        color: var(--texto-sub);
    }
    .empty-cart i { font-size: 56px; color: #cbd5e0; margin-bottom: 16px; }
    .empty-cart h3 { font-size: 18px; font-weight: 700; color: var(--texto); margin-bottom: 8px; }
    .empty-cart p { font-size: 14px; margin-bottom: 20px; }
    .btn-ir {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--naranja); color: #fff; padding: 11px 24px;
        border-radius: 10px; font-weight: 700; font-size: 14px;
        text-decoration: none; transition: background .2s;
    }
    .btn-ir:hover { background: var(--naranja-dk); }

    @media (max-width: 860px) {
        .layout-carrito { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="container" style="padding-top:0;padding-bottom:0">
        <h1><i class="fas fa-shopping-cart"></i> Carrito de Compras</h1>
    </div>
</div>

<div class="container">

    @if($detalles->isEmpty())
        {{-- Carrito vacío --}}
        <div class="card">
            <div class="empty-cart">
                <i class="fas fa-cart-xmark"></i>
                <h3>Tu carrito está vacío</h3>
                <p>Agrega productos desde el catálogo para comenzar tu compra.</p>
                <a href="{{ route('catalogo') }}" class="btn-ir">
                    <i class="fas fa-store"></i> Ir al catálogo
                </a>
            </div>
        </div>

    @else
        <div class="layout-carrito">

            {{-- Lista de productos --}}
            <div class="card">
                <div class="card-head">
                    <h2>Productos en tu carrito</h2>
                    <span class="badge">{{ $detalles->count() }} artículo(s)</span>
                </div>

                @foreach($detalles as $detalle)
                    <div class="cart-item">
                        {{-- Imagen --}}
                        <div class="item-img">
                            @if($detalle->producto->imagen)
                                <img src="{{ asset('storage/' . $detalle->producto->imagen) }}" alt="{{ $detalle->producto->nombre }}">
                            @else
                                <i class="fas fa-box"></i>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="item-info">
                            <div class="item-name">{{ $detalle->producto->nombre }}</div>
                            <div class="item-price">${{ number_format($detalle->precio_unitario, 2) }} c/u</div>
                        </div>

                        {{-- Cantidad --}}
                        <form method="POST" action="{{ route('carrito.actualizar') }}">
                            @csrf
                            <input type="hidden" name="detalle_id" value="{{ $detalle->id }}">
                            <div class="qty-control">
                                <button type="button" class="qty-btn" onclick="cambiarCantidad(this, -1)">−</button>
                                <input type="number" name="cantidad" class="qty-input"
                                    value="{{ $detalle->cantidad }}" min="1"
                                    onchange="this.form.submit()">
                                <button type="button" class="qty-btn" onclick="cambiarCantidad(this, 1)">+</button>
                            </div>
                        </form>

                        {{-- Subtotal --}}
                        <div class="item-subtotal">
                            ${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}
                        </div>

                        {{-- Eliminar --}}
                        <form method="POST" action="{{ route('carrito.eliminar', $detalle->id) }}">
                            @csrf
                            <button type="submit" class="btn-delete" title="Eliminar producto">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Resumen de compra --}}
            <div>
                <div class="card">
                    <div class="card-head">
                        <h2>Resumen de compra</h2>
                    </div>

                    @foreach($detalles as $d)
                        <div class="summary-row">
                            <span class="label">{{ Str::limit($d->producto->nombre, 22) }}</span>
                            <span class="value">${{ number_format($d->precio_unitario * $d->cantidad, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="summary-total">
                        <span class="label">Total</span>
                        <span class="value">${{ number_format($total, 2) }}</span>
                    </div>

                    <div class="summary-actions">
                        <form method="POST" action="{{ route('carrito.finalizar') }}">
                            @csrf
                            <button type="submit" class="btn-checkout">
                                <i class="fas fa-credit-card"></i> Finalizar compra
                            </button>
                        </form>
                        <a href="{{ route('catalogo') }}" class="btn-continue">
                            <i class="fas fa-arrow-left"></i> Continuar comprando
                        </a>
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
function cambiarCantidad(btn, delta) {
    const input = btn.parentElement.querySelector('.qty-input');
    const nuevo = Math.max(1, parseInt(input.value) + delta);
    input.value = nuevo;
    input.form.submit();
}
</script>
@endpush
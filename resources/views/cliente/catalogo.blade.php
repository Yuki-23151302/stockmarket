@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@push('styles')
<style>
    /* ── Filtros de categoría ─────────────────── */
    .cat-bar {
        background: #fff;
        border-bottom: 1px solid var(--gris-borde);
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .cat-bar::-webkit-scrollbar { display: none; }
    .cat-btn {
        flex-shrink: 0;
        padding: 10px 18px;
        border: none;
        background: none;
        font-family: 'Nunito', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--texto-sub);
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: color .15s, border-color .15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .cat-btn:hover { color: var(--azul); }
    .cat-btn.active { color: var(--naranja); border-bottom-color: var(--naranja); }

    /* ── Header sección ──────────────────────── */
    .section-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-header h2 {
        font-size: 22px;
        font-weight: 800;
        color: var(--azul);
    }
    .section-header .count {
        font-size: 13px;
        color: var(--texto-sub);
    }

    /* ── Grid de productos ───────────────────── */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(30,58,95,.07);
        transition: transform .2s, box-shadow .2s;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(30,58,95,.13);
    }

    .product-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: #f0f4f8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e0;
        font-size: 40px;
    }
    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-body {
        padding: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .product-cat {
        font-size: 11px;
        font-weight: 700;
        color: var(--naranja);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 4px;
    }
    .product-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--texto);
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .product-desc {
        font-size: 12px;
        color: var(--texto-sub);
        line-height: 1.5;
        flex: 1;
        margin-bottom: 12px;
    }
    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .product-price {
        font-size: 20px;
        font-weight: 800;
        color: var(--azul);
    }
    .product-price span {
        font-size: 12px;
        font-weight: 600;
        color: var(--texto-sub);
    }

    .btn-add {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--naranja);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        cursor: pointer;
        transition: background .2s;
        white-space: nowrap;
    }
    .btn-add:hover { background: var(--naranja-dk); }

    /* ── Sin resultados ──────────────────────── */
    .empty-state {
        text-align: center;
        padding: 64px 20px;
        color: var(--texto-sub);
    }
    .empty-state i { font-size: 48px; color: #cbd5e0; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 700; color: var(--texto); margin-bottom: 8px; }
    .empty-state p { font-size: 14px; }
</style>
@endpush

@section('content')

{{-- Barra de categorías --}}
<div class="cat-bar">
    <a href="{{ route('catalogo') }}"
       class="cat-btn {{ !request('categoria_id') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Todos
    </a>
    @foreach($categorias as $cat)
        <a href="{{ route('catalogo', ['categoria_id' => $cat->id]) }}"
           class="cat-btn {{ request('categoria_id') == $cat->id ? 'active' : '' }}">
            {{ $cat->nombre }}
        </a>
    @endforeach
</div>

<div class="container">

    {{-- Encabezado --}}
    <div class="section-header">
        <div>
            <h2>
                @if(request('buscar'))
                    Resultados para "{{ request('buscar') }}"
                @elseif(request('categoria_id'))
                    {{ $categorias->find(request('categoria_id'))->nombre ?? 'Categoría' }}
                @else
                    Todos los Productos
                @endif
            </h2>
        </div>
        <span class="count">{{ $productos->count() }} producto(s) encontrado(s)</span>
    </div>

    {{-- Grid --}}
    @if($productos->isEmpty())
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>No se encontraron productos</h3>
            <p>Intenta con otra búsqueda o categoría.</p>
        </div>
    @else
        <div class="products-grid">
            @foreach($productos as $producto)
                <div class="product-card">
                    {{-- Imagen --}}
                    <div class="product-img">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                        @else
                            <i class="fas fa-box"></i>
                        @endif
                    </div>

                    {{-- Datos --}}
                    <div class="product-body">
                        <div class="product-cat">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>
                        <div class="product-name">{{ $producto->nombre }}</div>
                        @if($producto->descripcion)
                            <div class="product-desc">{{ Str::limit($producto->descripcion, 60) }}</div>
                        @endif

                        <div class="product-footer">
                            <div class="product-price">
                                ${{ number_format($producto->precio, 2) }}
                            </div>

                            <form method="POST" action="{{ route('carrito.agregar') }}">
                                @csrf
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn-add">
                                    <i class="fas fa-cart-plus"></i> Agregar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
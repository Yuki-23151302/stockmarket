<!DOCTYPE html>
<html>
<head>
    <title>Catálogo</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; }
        .container { width: 90%; margin: auto; }
        .card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .precio { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>Catálogo de Productos</h1>

    @foreach($productos as $producto)
        <div class="card">
            <h3>{{ $producto->nombre }}</h3>
            <p>{{ $producto->descripcion }}</p>
            <p class="precio">$ {{ $producto->precio }}</p>
            <p>Stock: {{ $producto->stock }}</p>
        </div>
    @endforeach

</div>

</body>
</html>

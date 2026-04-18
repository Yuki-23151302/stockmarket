<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Usuarios ─────────────────────────────────
        User::create([
            'name'          => 'Administrador',
            'email'         => 'admin@example.com',
            'password'      => Hash::make('admin123'),
            'rol'           => 'admin',
        ]);

        User::create([
            'name'          => 'Juan Cliente',
            'email'         => 'cliente@example.com',
            'password'      => Hash::make('cliente123'),
            'rol'           => 'cliente',
            'direccion'     => 'Calle Principal #123',
            'ciudad'        => 'Aguascalientes',
            'codigo_postal' => '20000',
            'pais'          => 'México',
        ]);

        // ── Categorías ───────────────────────────────
        $categorias = [
            ['nombre' => 'Lácteos',              'descripcion' => 'Leche, queso, yogurt y derivados'],
            ['nombre' => 'Panadería',             'descripcion' => 'Pan, tortillas y productos de harina'],
            ['nombre' => 'Granos',                'descripcion' => 'Arroz, frijol, lenteja y cereales'],
            ['nombre' => 'Aceites',               'descripcion' => 'Aceites y grasas vegetales'],
            ['nombre' => 'Condimentos',           'descripcion' => 'Sal, especias y aderezos'],
            ['nombre' => 'Enlatados',             'descripcion' => 'Conservas y productos enlatados'],
            ['nombre' => 'Bebidas',               'descripcion' => 'Agua, refrescos y jugos'],
            ['nombre' => 'Limpieza',              'descripcion' => 'Productos de limpieza del hogar'],
            ['nombre' => 'Higiene Personal',      'descripcion' => 'Jabón, shampoo y cuidado personal'],
            ['nombre' => 'Snacks',                'descripcion' => 'Botanas, galletas y golosinas'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }

        // ── Productos ────────────────────────────────
        $productos = [
            // Lácteos
            ['nombre' => 'Leche Entera 1 Litro',     'descripcion' => 'Leche fresca entera pasteurizada, ideal para toda la familia.', 'precio' => 24.50, 'stock' => 80,  'categoria_id' => 1],
            ['nombre' => 'Yogurt Natural 1L',         'descripcion' => 'Yogurt natural cremoso sin azúcar añadida.', 'precio' => 38.00, 'stock' => 40,  'categoria_id' => 1],
            ['nombre' => 'Queso Manchego 400g',       'descripcion' => 'Queso manchego suave, ideal para sándwiches.',  'precio' => 65.00, 'stock' => 25,  'categoria_id' => 1],
            ['nombre' => 'Huevos Blancos (12 piezas)','descripcion' => 'Huevos frescos de granja, tamaño grande.',     'precio' => 52.00, 'stock' => 60,  'categoria_id' => 1],

            // Panadería
            ['nombre' => 'Pan Blanco Integral',       'descripcion' => 'Pan de caja integral, suave y nutritivo, 680g.',  'precio' => 32.00, 'stock' => 35,  'categoria_id' => 2],
            ['nombre' => 'Tortillas de Maíz 1kg',     'descripcion' => 'Tortillas de maíz artesanales, suaves y frescas.','precio' => 18.00, 'stock' => 50,  'categoria_id' => 2],

            // Granos
            ['nombre' => 'Arroz Blanco 1 Kg',         'descripcion' => 'Arroz de grano largo, de la más alta calidad.',   'precio' => 28.00, 'stock' => 120, 'categoria_id' => 3],
            ['nombre' => 'Frijol Negro 1kg',           'descripcion' => 'Frijol negro seleccionado, limpio y sin piedras.','precio' => 30.00, 'stock' => 90,  'categoria_id' => 3],
            ['nombre' => 'Lenteja 500g',               'descripcion' => 'Lentejas verdes de alta calidad, fáciles de cocer.','precio' => 20.00,'stock' => 70,  'categoria_id' => 3],

            // Aceites
            ['nombre' => 'Aceite Vegetal 1L',          'descripcion' => 'Aceite vegetal puro para cocinar.',               'precio' => 45.00, 'stock' => 55,  'categoria_id' => 4],

            // Condimentos
            ['nombre' => 'Sal de Mesa 1kg',            'descripcion' => 'Sal yodada refinada, ideal para cocinar.',        'precio' => 15.50, 'stock' => 8,   'categoria_id' => 5],
            ['nombre' => 'Azúcar Refinada 1kg',        'descripcion' => 'Azúcar blanca refinada de caña.',                 'precio' => 27.00, 'stock' => 200, 'categoria_id' => 5],

            // Enlatados
            ['nombre' => 'Salsa de Tomate 400g',       'descripcion' => 'Salsa de tomate natural, ideal para guisos.',     'precio' => 22.00, 'stock' => 45,  'categoria_id' => 6],
            ['nombre' => 'Atún en Agua 140g',          'descripcion' => 'Atún en agua, bajo en grasa y alto en proteína.', 'precio' => 19.00, 'stock' => 80,  'categoria_id' => 6],
            ['nombre' => 'Frijoles Negros 900g',       'descripcion' => 'Frijoles negros cocidos en lata.',                'precio' => 35.00, 'stock' => 60,  'categoria_id' => 6],

            // Bebidas
            ['nombre' => 'Agua Purificada 1.5L',       'descripcion' => 'Agua purificada en botella de plástico.',         'precio' => 14.00, 'stock' => 100, 'categoria_id' => 7],
            ['nombre' => 'Jugo de Naranja 1L',         'descripcion' => 'Jugo de naranja 100% natural sin azúcar.',        'precio' => 29.00, 'stock' => 30,  'categoria_id' => 7],

            // Limpieza
            ['nombre' => 'Detergente Líquido 3L',      'descripcion' => 'Detergente líquido concentrado para ropa.',       'precio' => 95.00, 'stock' => 20,  'categoria_id' => 8],
            ['nombre' => 'Jabón de Tocador 4 piezas',  'descripcion' => 'Jabón de tocador con humectantes naturales.',     'precio' => 42.00, 'stock' => 50,  'categoria_id' => 8],
            ['nombre' => 'Papel Higiénico 12 Rollos',  'descripcion' => 'Papel higiénico doble hoja, ultra suave.',        'precio' => 85.00, 'stock' => 5,   'categoria_id' => 8],

            // Higiene Personal
            ['nombre' => 'Shampoo 400ml',              'descripcion' => 'Shampoo para todo tipo de cabello.',              'precio' => 55.00, 'stock' => 35,  'categoria_id' => 9],

            // Snacks
            ['nombre' => 'Galletas Integrales 200g',   'descripcion' => 'Galletas integrales de avena, nutritivas.',       'precio' => 24.00, 'stock' => 60,  'categoria_id' => 10],
            ['nombre' => 'Pasta Espagueti 500g',       'descripcion' => 'Pasta de sémola de trigo, cocción perfecta.',     'precio' => 18.50, 'stock' => 75,  'categoria_id' => 3],
        ];

        foreach ($productos as $prod) {
            Producto::create($prod);
        }
    }
}
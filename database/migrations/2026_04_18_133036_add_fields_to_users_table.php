<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol')->default('cliente')->after('email'); // 'admin' o 'cliente'
            $table->string('direccion')->nullable()->after('rol');
            $table->string('ciudad')->nullable()->after('direccion');
            $table->string('codigo_postal', 10)->nullable()->after('ciudad');
            $table->string('pais')->nullable()->after('codigo_postal');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'direccion', 'ciudad', 'codigo_postal', 'pais']);
        });
    }
};

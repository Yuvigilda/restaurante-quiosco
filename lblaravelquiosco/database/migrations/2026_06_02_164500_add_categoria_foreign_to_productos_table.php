<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La tabla categorias se crea despues de productos.
     * La llave foranea se agrega cuando las dos tablas ya existen.
     */
    public function up(): void
    {
        if (! Schema::hasTable('productos') || ! Schema::hasTable('categorias')) {
            return;
        }

        $yaExiste = collect(Schema::getForeignKeys('productos'))
            ->contains(fn (array $key) => in_array('categoria_id', $key['columns'] ?? [], true));

        if ($yaExiste) {
            return;
        }

        Schema::table('productos', function (Blueprint $table) {
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('productos')) {
            return;
        }

        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
        });
    }
};

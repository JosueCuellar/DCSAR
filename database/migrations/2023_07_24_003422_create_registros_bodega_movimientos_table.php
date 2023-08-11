<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_bodega_movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_bodega_id')->unsigned();
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_nueva');
            $table->timestamp('fecha_cambio');
            $table->foreign('producto_bodega_id')->references('id')->on('producto_bodegas');
        });

				// Crear un trigger que registra inserciones en la tabla producto_bodegas

        DB::unprepared("
            CREATE TRIGGER registrar_insert_producto_bodegas
            ON producto_bodegas
            AFTER INSERT
            AS
            BEGIN
                INSERT INTO registros_bodega_movimientos (producto_bodega_id, cantidad_anterior, cantidad_nueva, fecha_cambio)
                SELECT i.id, 0, i.cantidadDisponible, GETDATE()
                FROM inserted i;
            END;
        ");

				// Crear un trigger que registra actualizaciones en la tabla producto_bodegas

        DB::unprepared("
            CREATE TRIGGER registrar_update_producto_bodegas
            ON producto_bodegas
            AFTER UPDATE
            AS
            BEGIN
                INSERT INTO registros_bodega_movimientos (producto_bodega_id, cantidad_anterior, cantidad_nueva, fecha_cambio)
                SELECT i.id, d.cantidadDisponible, i.cantidadDisponible, GETDATE()
                FROM inserted i
                INNER JOIN deleted d ON i.id = d.id
                WHERE i.cantidadDisponible != d.cantidadDisponible;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros_bodega_movimientos');
    }
};

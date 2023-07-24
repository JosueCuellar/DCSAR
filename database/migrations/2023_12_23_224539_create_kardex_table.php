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
		Schema::create('kardex', function (Blueprint $table) {
			$table->id();
			$table->dateTime('fecha_movimiento');
			$table->enum('tipo_movimiento', ['entrada', 'salida']);
			$table->unsignedBigInteger('producto_id');
			$table->integer('cantidad');
			$table->decimal('precio_promedio', 12, 2);
			$table->foreign('producto_id')->references('id')->on('productos');
			$table->unsignedBigInteger('detalle_requisicion_id')->nullable();
			$table->unsignedBigInteger('detalle_compra_id')->nullable();
			$table->unsignedBigInteger('requisicion_id')->nullable();
			$table->unsignedBigInteger('recepcion_id')->nullable();
			$table->softDeletes();
		});

		DB::unprepared("
            CREATE TRIGGER registrar_entrada
            ON recepcion_compras
            AFTER UPDATE
            AS
            BEGIN
                IF UPDATE(inicializado)
                BEGIN
									INSERT INTO kardex (fecha_movimiento, tipo_movimiento, producto_id, cantidad, precio_promedio, detalle_compra_id, recepcion_id)
									SELECT i.fechaIngreso, 'entrada', detalle_compras.producto_id, detalle_compras.cantidadIngreso, detalle_compras.precioUnidad, detalle_compras.id, i.id
									FROM inserted i
									JOIN detalle_compras ON detalle_compras.recepcion_compra_id = i.id
									WHERE i.inicializado = 1;								
                END
            END;
        ");

		DB::unprepared("
            CREATE TRIGGER registrar_salida
            ON requisicion_productos
            AFTER UPDATE
            AS
            BEGIN
                IF UPDATE(estado_id)
                BEGIN
									INSERT INTO kardex (fecha_movimiento, tipo_movimiento, producto_id, cantidad, precio_promedio, detalle_requisicion_id, requisicion_id)
									SELECT i.fechaRequisicion, 'salida', detalle_requisicions.producto_id, detalle_requisicions.cantidad, detalle_requisicions.precioPromedio, detalle_requisicions.id, i.id
									FROM inserted i
									JOIN detalle_requisicions ON detalle_requisicions.requisicion_id = i.id
									WHERE i.estado_id = 4;								
                END
            END;
        ");

		DB::unprepared("
						CREATE TRIGGER actualizar_kardex_despues_actualizar_detalle_requisicion
						ON detalle_requisicions
						AFTER UPDATE
						AS
						BEGIN
								UPDATE kardex
								SET cantidad = i.cantidad,
										precio_promedio = i.precioPromedio
								FROM inserted i
								WHERE kardex.detalle_requisicion_id = i.id;
						END;
        ");

		DB::unprepared("
						CREATE TRIGGER actualizar_kardex_despues_actualizar_detalle_compra
						ON detalle_compras
						AFTER UPDATE
						AS
						BEGIN
								UPDATE kardex
								SET cantidad = i.cantidadIngreso,
										precio_promedio = i.precioUnidad
								FROM inserted i
								WHERE kardex.detalle_compra_id = i.id;
						END;
        ");

		DB::unprepared("
						CREATE TRIGGER actualizar_kardex_despues_borrar_detalle_requisicion
						ON detalle_requisicions
						AFTER DELETE
						AS
						BEGIN
								UPDATE kardex
								SET deleted_at = GETDATE()
								WHERE kardex.detalle_requisicion_id IN (SELECT id FROM deleted);
						END;
        ");

		DB::unprepared("
						CREATE TRIGGER actualizar_kardex_despues_borrar_detalle_compra
						ON detalle_compras
						AFTER DELETE
						AS
						BEGIN
								UPDATE kardex
								SET deleted_at = GETDATE()
								WHERE kardex.detalle_compra_id IN (SELECT id FROM deleted);
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
		Schema::dropIfExists('kardex');
	}
};
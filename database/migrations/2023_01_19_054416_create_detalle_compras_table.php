<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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


		Schema::create('detalle_compras', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('producto_id');
			$table->unsignedBigInteger('recepcion_compra_id');
			$table->foreign('producto_id')->references('id')->on('productos');
			$table->foreign('recepcion_compra_id')->references('id')->on('recepcion_compras')->onDelete('cascade');
			$table->integer('cantidadIngreso');
			$table->string('fechaVencimiento')->nullable();
			$table->decimal('precioUnidad', $precision = 12, $scale = 2);
			$table->decimal('total', $precision = 12, $scale = 2);
			$table->timestamps();
			$table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('detalle_compras');
	}
};

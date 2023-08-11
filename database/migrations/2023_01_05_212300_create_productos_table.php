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
		Schema::create('productos', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('marca_id')->unsigned();
			$table->unsignedBigInteger('medida_id')->unsigned();
			$table->unsignedBigInteger('rubro_id')->unsigned();
			$table->string('codProducto', 15)->unique();
			$table->string('descripcion', 50);
			$table->boolean('perecedero');
			$table->decimal('costoPromedio', $precision = 12, $scale = 2)->nullable();
			$table->string('observacion', 50)->nullable();
			$table->string('imagen');
			$table->foreign('marca_id')->references('id')->on('marcas');
			$table->foreign('medida_id')->references('id')->on('medidas');
			$table->foreign('rubro_id')->references('id')->on('rubros');
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
		Schema::dropIfExists('productos');
	}
};

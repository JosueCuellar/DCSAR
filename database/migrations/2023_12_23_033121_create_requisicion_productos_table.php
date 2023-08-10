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
		Schema::create('requisicion_productos', function (Blueprint $table) {
			$table->id();
			$table->dateTime('fechaRequisicion');
			$table->string('nCorrelativo')->nullable();
			$table->string('descripcion', 255)->nullable();
			$table->string('observacion', 255)->nullable();
			$table->unsignedBigInteger('estado_id')->unsigned();
			$table->foreign('estado_id')->references('id')->on('estados');
			// Agregar columna user_id y establecer relación de clave foránea con la tabla usuarios
			$table->unsignedBigInteger('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('usuarios');
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
		Schema::dropIfExists('requisicion_productos');
	}
};

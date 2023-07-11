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
		Schema::create('proveedors', function (Blueprint $table) {
			$table->id();
			$table->string('nombreComercial', 255);
			$table->string('razonSocial', 255);
			$table->string('direccionProveedor', 255);
			$table->string('fax', 150)->nullable();
			$table->string('telefonoProveedor1', 15);
			$table->string('telefonoProveedor2', 15)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('proveedors');
	}
};

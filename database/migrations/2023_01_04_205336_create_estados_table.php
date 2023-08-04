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
		Schema::create('estados', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->string('codigoEstado', 10);
			$table->string('nombreEstado', 50);
			$table->string('descripcionEstado', 50);
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
		Schema::dropIfExists('estados');
	}
};

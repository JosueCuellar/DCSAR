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
		Schema::create('usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('name', 60);
			$table->unsignedBigInteger('unidad_organizativa_id')->nullable();
			$table->foreign('unidad_organizativa_id')->references('id')->on('unidad_organizativas');
			$table->string('email', 100)->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
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
		Schema::dropIfExists('usuarios');
	}
};

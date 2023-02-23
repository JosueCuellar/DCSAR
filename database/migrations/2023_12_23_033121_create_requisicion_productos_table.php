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
            $table->dateTime('fecha_requisicion');
            $table->string('nCorrelativo')->nullable();
            $table->string('descripcion',512)->nullable();
            $table->string('observacion',512)->nullable();
            $table->unsignedBigInteger('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('requisicion_productos');
    }
};

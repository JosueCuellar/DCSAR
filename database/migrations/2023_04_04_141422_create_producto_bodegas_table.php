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
        Schema::create('producto_bodegas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id')->unsigned();
            $table->unsignedBigInteger('bodega_id')->unsigned();
            $table->integer('cantidadDisponible');
            $table->foreign('bodega_id')->references('id')->on('bodegas');
            $table->foreign('producto_id')->references('id')->on('productos');
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
        Schema::dropIfExists('producto_bodegas');
    }
};

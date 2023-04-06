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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detalleCompra_id')->unsigned();
            $table->unsignedBigInteger('producto_id')->unsigned();
            // $table->unsignedBigInteger('bodega_id')->unsigned();
            $table->string('fechaVencimiento',10)->nullable();
            $table->integer('cantidadDisponible');
            // $table->foreign('bodega_id')->references('id')->on('bodegas');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('detalleCompra_id')->references('id')->on('detalle_compras')->onDelete('cascade');
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
        Schema::dropIfExists('lotes');
    }
};

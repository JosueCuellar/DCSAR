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
            $table->unsignedBigInteger('recepcionCompra_id');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('recepcionCompra_id')->references('id')->on('recepcion_compras')->onDelete('cascade');
            $table->integer('cantidadIngreso');
            $table->decimal('precioUnidad', $precision = 12, $scale = 2);
            $table->decimal('total', $precision = 12, $scale = 2);
            $table->string('fechaVenc',10)->nullable();
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
        Schema::dropIfExists('detalle_compras');
    }
};

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
        Schema::create('detalle_requisicions', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->integer('cantidad_entregada')->nullable();
            $table->decimal('precio_promedio', $precision = 10, $scale = 2);
            $table->unsignedBigInteger('requisicion_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('total', $precision = 12, $scale = 2);
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('requisicion_id')->references('id')->on('requisicion_productos')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_requisicions');
    }
};

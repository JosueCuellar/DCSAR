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
        Schema::create('documento_x_compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombreDocumento');
            $table->unsignedBigInteger('recepcionCompra_id');
            $table->foreign('recepcionCompra_id')->references('id')->on('recepcion_compras')->cascadeOnDelete();
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
        Schema::dropIfExists('documento_x_compras');
    }
};

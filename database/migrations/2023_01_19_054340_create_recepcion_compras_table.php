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
        Schema::create('recepcion_compras', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_ingreso',10)->nullable();
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->string('nOrdenCompra',50);
            $table->string('nPresupuestario',50);
            // $table->string('nCompromiso',50);
            $table->boolean('estado');
            $table->string('codigo_factura',50);
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
        Schema::dropIfExists('recepcion_compras');
    }
};

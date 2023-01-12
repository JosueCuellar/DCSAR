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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marca_id')->unsigned();
            $table->unsignedBigInteger('medida_id')->unsigned();
            $table->unsignedBigInteger('rubro_id')->unsigned();
            $table->unsignedBigInteger('estado_id')->unsigned();
            $table->string('cod_producto',250);
            $table->string('descripcion',250);
            $table->string('observacion',250);
            $table->string('imagen');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('medida_id')->references('id')->on('medidas');
            $table->foreign('rubro_id')->references('id')->on('rubros');
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
        Schema::dropIfExists('productos');
    }
};

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Estados
        DB::table('estados')->insert([
            'codigoEstado' => 'SE',
            'descripcionEstado' => 'Una requisicion ha sido enviada',
            'nombreEstado' => 'Solicitud Enviada',
        ]);


        DB::table('estados')->insert([
            'codigoEstado' => 'SSC',
            'descripcionEstado' => 'Una requisicion sin completar',
            'nombreEstado' => 'Solicitud SIN COMPLETAR',
        ]);


        DB::table('estados')->insert([
            'codigoEstado' => 'SA',
            'descripcionEstado' => 'Una requisicion ha sido aprobada',
            'nombreEstado' => 'Solicitud Aprobada',
        ]);

        DB::table('estados')->insert([
            'codigoEstado' => 'SR',
            'descripcionEstado' => 'Una requisicion ha sido rechazada',
            'nombreEstado' => 'Solicitud Rechazada',
        ]);



        //Marcas
        DB::table('marcas')->insert([
            'nombre' => 'Marca 1',
        ]);
        DB::table('marcas')->insert([
            'nombre' => 'Marca 2',
        ]);
        DB::table('marcas')->insert([
            'nombre' => 'Marca 3',
        ]);
        DB::table('marcas')->insert([
            'nombre' => 'Marca 4',
        ]);

        //Marcas
        DB::table('medidas')->insert([
            'nombreMedida' => 'Kilos(kg)',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Cajas',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Rollos',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Paquetes',
        ]);

        //Medidas
        DB::table('medidas')->insert([
            'nombreMedida' => 'Kilos(kg)',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Cajas',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Rollos',
        ]);
        DB::table('medidas')->insert([
            'nombreMedida' => 'Paquetes',
        ]);

        //Rubros
        DB::table('rubros')->insert([
            'codigoPresupuestario' => '5000',
            'descripcionRubro' => 'Descripcion 5000',
        ]);
        DB::table('rubros')->insert([
            'codigoPresupuestario' => '5001',
            'descripcionRubro' => 'Descripcion 5001',
        ]);
        DB::table('rubros')->insert([
            'codigoPresupuestario' => '5002',
            'descripcionRubro' => 'Descripcion 5002',
        ]);
        DB::table('rubros')->insert([
            'codigoPresupuestario' => '5003',
            'descripcionRubro' => 'Descripcion 5004',
        ]);


        //Rubros
        DB::table('proveedors')->insert([
            'nombreComercial' => 'Proveedor',
            'razonSocial' => 'Proveedor',
            'direccion' =>  'Direccion',
            'fax' => '5000',
            'telefono1' => '22222222',
            'telefono2' => '22222222',

        ]);
    }
}

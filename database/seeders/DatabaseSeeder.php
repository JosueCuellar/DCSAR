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
            'descripcionEstado' => 'Una requisición ha sido enviada',
            'nombreEstado' => 'Solicitud Enviada',
        ]);


        DB::table('estados')->insert([
            'codigoEstado' => 'SSC',
            'descripcionEstado' => 'Una requisición sin completar',
            'nombreEstado' => 'Solicitud SIN COMPLETAR',
        ]);


        DB::table('estados')->insert([
            'codigoEstado' => 'SA',
            'descripcionEstado' => 'Una requisición ha sido aprobada',
            'nombreEstado' => 'Solicitud Aprobada',
        ]);

        DB::table('estados')->insert([
            'codigoEstado' => 'SR',
            'descripcionEstado' => 'Una requisición ha sido rechazada',
            'nombreEstado' => 'Solicitud Rechazada',
        ]);

        DB::table('estados')->insert([
            'codigoEstado' => 'SEN',
            'descripcionEstado' => 'Una requisición ha sido entregada',
            'nombreEstado' => 'Solicitud Entregada',
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

    }
}

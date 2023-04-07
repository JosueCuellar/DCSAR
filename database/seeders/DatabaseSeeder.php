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
            'codigo_estado' => 'SE',
            'descripcion_estado' => 'Una requisición ha sido enviada',
            'nombre_estado' => 'Solicitud Enviada',
        ]);

        DB::table('estados')->insert([
            'codigo_estado' => 'SA',
            'descripcion_estado' => 'Una requisición ha sido aprobada',
            'nombre_estado' => 'Solicitud Aprobada',
        ]);

        DB::table('estados')->insert([
            'codigo_estado' => 'SR',
            'descripcion_estado' => 'Una requisición ha sido rechazada',
            'nombre_estado' => 'Solicitud Rechazada',
        ]);

        DB::table('estados')->insert([
            'codigo_estado' => 'SEN',
            'descripcion_estado' => 'Una requisición ha sido entregada',
            'nombre_estado' => 'Solicitud Entregada',
        ]);

        DB::table('estados')->insert([
            'codigo_estado' => 'NA',
            'descripcion_estado' => 'No terminada',
            'nombre_estado' => 'NA',
        ]);

        //Medidas
        DB::table('medidas')->insert([
            'nombre_medida' => 'Kilos(kg)',
        ]);
        DB::table('medidas')->insert([
            'nombre_medida' => 'Cajas',
        ]);
        DB::table('medidas')->insert([
            'nombre_medida' => 'Rollos',
        ]);
        DB::table('medidas')->insert([
            'nombre_medida' => 'Paquetes',
        ]);


        //Bodegas
        DB::table('bodegas')->insert([
            'nombre_bodega' => 'Bodega principal',
            'ubicacion' => 'Nivel 1',
        ]);

        DB::table('bodegas')->insert([
            'nombre_bodega' => 'Bodega secundaria',
            'ubicacion' => 'Nivel 1',
        ]);

    }
}

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

        DB::table('estados')->insert([
            'codigoEstado' => 'Solicitud Enviada',
            'descripcionEstado' => 'Una requisicion ha sido enviada',
            'nombreEstado' => 'Solicitud Enviada',
        ]);

        
        DB::table('estados')->insert([
            'codigoEstado' => 'Sin completar',
            'descripcionEstado' => 'Una requisicion sin completar',
            'nombreEstado' => 'Solicitud SIN COMPLETAR',
        ]);

        
        DB::table('estados')->insert([
            'codigoEstado' => 'Solicitud Aprobada',
            'descripcionEstado' => 'Una requisicion ha sido aprobada',
            'nombreEstado' => 'Solicitud aprobada',
        ]);

        DB::table('estados')->insert([
            'codigoEstado' => 'Solicitud Rechazada',
            'descripcionEstado' => 'Una requisicion ha sido rechazada',
            'nombreEstado' => 'Solicitud Rechazada',
        ]);

    }
}

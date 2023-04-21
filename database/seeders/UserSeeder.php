<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ])->assignRole('Super Administrador');

        User::create([
            'name' => 'Gerente UO',
            'email' => 'gerenteUO@gerenteUO.com',
            'password' => bcrypt('password')
        ])->assignRole('Gerente Unidad Organizativa');

        User::create([
            'name' => 'Gerente Encargado',
            'email' => 'gerente@gerente.com',
            'password' => bcrypt('password')
        ])->assignRole('Gerente Encargado Almacen');

        User::create([
            'name' => 'Tecnico',
            'email' => 'tecnico@tecnico.com',
            'password' => bcrypt('password')
        ])->assignRole('Tecnico Encargado Almacen');

        User::create([
            'name' => 'Solicitante',
            'email' => 'solicitante@solicitante.com',
            'password' => bcrypt('password')
        ])->assignRole('Solicitante Unidad Organizativa');



    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		//

		// DB::table('unidad_organizativas')->insert([
		// 	['nombreUnidadOrganizativa' => 'Unidad Logistica', 'descripUnidadOrganizativa' => 'Unidad Logistica'],
		// 	['nombreUnidadOrganizativa' => 'Gerencia de Sistemas Informaticos', 'descripUnidadOrganizativa' => 'Gerencia de Sistemas Informaticos'],
		// 	['nombreUnidadOrganizativa' => 'Gerencia Administracion', 'descripUnidadOrganizativa' => 'Gerencia Administracion'],
		// ]);

		User::create([
			'name' => 'Super Admin',
			'email' => 'admin@admin.com',
			'password' => bcrypt('password')
		])->assignRole('Super Administrador');

		// User::create([
		// 	'name' => 'Gerente Encargado',
		// 	'unidad_organizativa_id' => 1,
		// 	'email' => 'gerente@gerente.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Gerente Encargado Almacen');

		// User::create([
		// 	'name' => 'Carlos Rivas',
		// 	'unidad_organizativa_id' => 1,
		// 	'email' => 'carlos@carlos.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Tecnico Encargado Almacen');

		// User::create([
		// 	'name' => 'Josue Ernesto Cruz Cuellar',
		// 	'unidad_organizativa_id' => 1,
		// 	'email' => 'josue@josue.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Solicitante Unidad Organizativa');

		// User::create([
		// 	'name' => 'Gerente Josue Ernesto Cruz Cuellar',
		// 	'unidad_organizativa_id' => 1,
		// 	'email' => 'gerentejosue@gerentejosue.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Gerente Unidad Organizativa');

		// User::create([
		// 	'name' => 'Ana Cecilia Cuellar Rodriguez',
		// 	'unidad_organizativa_id' => 2,
		// 	'email' => 'ana@ana.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Solicitante Unidad Organizativa');

		// User::create([
		// 	'name' => 'Gerente Cecilia Cuellar Rodriguez',
		// 	'unidad_organizativa_id' => 2,
		// 	'email' => 'gerenteana@gerenteana.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Gerente Unidad Organizativa');

		// User::create([
		// 	'name' => 'Milena Abigail Barahona Mayen',
		// 	'unidad_organizativa_id' => 3,
		// 	'email' => 'milena@milena.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Solicitante Unidad Organizativa');

		// User::create([
		// 	'name' => 'Gerente Milena Abigail Barahona Mayen',
		// 	'unidad_organizativa_id' => 3,
		// 	'email' => 'gerentemilena@gerentemilena.com',
		// 	'password' => bcrypt('password')
		// ])->assignRole('Gerente Unidad Organizativa');
	}
}

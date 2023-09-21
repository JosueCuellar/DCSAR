<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		//------------------------------------------VISUALES-----------------------------------------------
		//Permiso administrador
		Permiso::create(['name' => 'Ver panel admin']);

		//Dashboard
		Permiso::create(['name' => 'Ver dashboard: Cantidad de solicitudes']);
		Permiso::create(['name' => 'Ver dashboard: Accesos directos 1']);
		Permiso::create(['name' => 'Ver dashboard: Accesos directos 2']);

		//SIDEBAR
		Permiso::create(['name' => 'SideBar: Requisicion de producto']);
		Permiso::create(['name' => 'SideBar: Inventario']);
		Permiso::create(['name' => 'SideBar: Revisar solicitudes']);
		Permiso::create(['name' => 'SideBar: Ingreso de producto']);
		Permiso::create(['name' => 'SideBar: Solicitudes a entregar']);
		Permiso::create(['name' => 'SideBar: Historial requisiciones']);
		Permiso::create(['name' => 'SideBar: Productos Bodega']);
		Permiso::create(['name' => 'SideBar: Reportes']);
		Permiso::create(['name' => 'SideBar: Catalogos']);
	}
}

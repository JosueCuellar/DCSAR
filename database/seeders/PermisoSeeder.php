<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisoSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		//------------------------------------------VISUALES-----------------------------------------------
		//Permiso administrador
		Permission::create(['name' => 'Ver panel admin']);

		//Dashboard
		Permission::create(['name' => 'Ver dashboard: Cantidad de solicitudes']);
		Permission::create(['name' => 'Ver dashboard: Accesos directos 1']);
		Permission::create(['name' => 'Ver dashboard: Accesos directos 2']);

		//SIDEBAR
		Permission::create(['name' => 'SideBar: Requisicion de producto']);
		Permission::create(['name' => 'SideBar: Inventario']);
		Permission::create(['name' => 'SideBar: Revisar solicitudes']);
		Permission::create(['name' => 'SideBar: Ingreso de producto']);
		Permission::create(['name' => 'SideBar: Solicitudes a entregar']);
		Permission::create(['name' => 'SideBar: Historial requisiciones']);
		Permission::create(['name' => 'SideBar: Productos Bodega']);
		Permission::create(['name' => 'SideBar: Reportes']);
		Permission::create(['name' => 'SideBar: Catalogos']);
	}
}

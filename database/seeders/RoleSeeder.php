<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		//


		$roleAdmin = Role::create(['name' => 'Super Administrador']);
		$roleAdmin->givePermissionTo([
			'Ver panel admin',
			'Ver dashboard: Cantidad de solicitudes',
			'Ver dashboard: Accesos directos 1',
			'Ver dashboard: Accesos directos 2',
			'SideBar: Requisicion de producto',
			'SideBar: Inventario',
			'SideBar: Revisar solicitudes',
			'SideBar: Ingreso de producto',
			'SideBar: Solicitudes a entregar',
			'SideBar: Historial requisiciones',
			'SideBar: Productos Bodega',
			'SideBar: Reportes',
			'SideBar: Catalogos',
		]);



		$roleGerenteUO = Role::create(['name' => 'Gerente Unidad Organizativa']);
		$roleGerenteUO->givePermissionTo([
			'Ver dashboard: Cantidad de solicitudes',
			'Ver dashboard: Accesos directos 1',
			'SideBar: Requisicion de producto',
			'SideBar: Inventario',
			'SideBar: Revisar solicitudes',
		]);

		$roleGerenteAlmacen = Role::create(['name' => 'Gerente Encargado Almacen']);
		$roleGerenteAlmacen->givePermissionTo([
			'Ver dashboard: Cantidad de solicitudes',
			'Ver dashboard: Accesos directos 1',
			'SideBar: Requisicion de producto',
			'SideBar: Inventario',
			'SideBar: Revisar solicitudes',
			'SideBar: Ingreso de producto',
			'SideBar: Solicitudes a entregar',
			'SideBar: Historial requisiciones',
			'SideBar: Productos Bodega',
			'SideBar: Reportes',
			'SideBar: Catalogos',
		]);

		$roleTecnico = Role::create(['name' => 'Tecnico Encargado Almacen']);
		$roleTecnico->givePermissionTo([
			'Ver dashboard: Cantidad de solicitudes',
			'Ver dashboard: Accesos directos 1',
			'Ver dashboard: Accesos directos 2',
			'SideBar: Requisicion de producto',
			'SideBar: Inventario',
			'SideBar: Ingreso de producto',
			'SideBar: Solicitudes a entregar',
			'SideBar: Historial requisiciones',
			'SideBar: Productos Bodega',
			'SideBar: Reportes',
			'SideBar: Catalogos',
		]);


		$roleSolicitante = Role::create(['name' => 'Solicitante Unidad Organizativa']);
		$roleSolicitante->givePermissionTo([
			'Ver dashboard: Cantidad de solicitudes',
			'Ver dashboard: Accesos directos 1',
			'SideBar: Requisicion de producto',
			'SideBar: Inventario',
		]);
	}
}

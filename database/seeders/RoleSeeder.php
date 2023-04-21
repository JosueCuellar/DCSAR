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
        'CRUD estado',
        'CRUD marca',
        'CRUD proveedor',
        'CRUD medida',
        'CRUD unidad organizativa',
        'CRUD rubro',
        'CRUD producto',
        'Crear solicitud requisicion',
        'Ver estados de solicitudes',
        'Revision de solicitudes',
        'Bandeja solicitud a entregar',
        'Ver solicitudes realizadas',
        'Crear ingreso de productos',
        'Consultar ingreso de productos',
        'Ver inventario',
        'Ver bodega principal',
        'Catalogo'

    ]);



       $roleGerenteUO = Role::create(['name' => 'Gerente Unidad Organizativa']);
       $roleGerenteUO->givePermissionTo([
        'Crear solicitud requisicion',
        'Ver estados de solicitudes',
        'Revision de solicitudes',
        'Ver solicitudes realizadas',
        'Ver inventario'
    ]);
    


       $roleGerenteAlmacen = Role::create(['name' => 'Gerente Encargado Almacen']);
       $roleGerenteAlmacen->givePermissionTo([
        
        'Catalogo',
        'CRUD marca',
        'CRUD proveedor',
        'CRUD medida',
        'CRUD rubro',
        'CRUD producto',
        'Crear solicitud requisicion',
        'Ver estados de solicitudes',
        'Revision de solicitudes',
        'Bandeja solicitud a entregar',
        'Ver solicitudes realizadas',
        'Crear ingreso de productos',
        'Consultar ingreso de productos',
        'Ver inventario',
        'Ver bodega principal'
    ]);
       
       $roleTecnico = Role::create(['name' => 'Tecnico Encargado Almacen']);
       $roleTecnico->givePermissionTo([
        'Catalogo',
        'CRUD marca',
        'CRUD proveedor',
        'CRUD medida',
        'CRUD rubro',
        'CRUD producto',
        'Crear solicitud requisicion',
        'Ver estados de solicitudes',
        'Bandeja solicitud a entregar',
        'Ver solicitudes realizadas',
        'Crear ingreso de productos',
        'Consultar ingreso de productos',
        'Ver inventario',
        'Ver bodega principal'
    ]);

       
    $roleSolicitante = Role::create(['name' => 'Solicitante Unidad Organizativa']);
       $roleSolicitante->givePermissionTo([
        'Crear solicitud requisicion',
        'Ver estados de solicitudes',
        'Ver solicitudes realizadas',
        'Ver inventario'
    ]);


       
    }
}

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
        //Permiso administrador
        Permission::create(['name' => 'Ver panel admin']);


        //Permisos catalogos
        Permission::create(['name' => 'Catalogo']);

        Permission::create(['name' => 'CRUD estado']);
        Permission::create(['name' => 'CRUD marca']);
        Permission::create(['name' => 'CRUD proveedor']);
        Permission::create(['name' => 'CRUD medida']);
        Permission::create(['name' => 'CRUD unidad organizativa']);
        Permission::create(['name' => 'CRUD rubro']);
        Permission::create(['name' => 'CRUD producto']);


        //Permisos Requisiciones productos
        Permission::create(['name' => 'Crear solicitud requisicion']);
        Permission::create(['name' => 'Ver estados de solicitudes']);
        Permission::create(['name' => 'Revision de solicitudes']);
        Permission::create(['name' => 'Bandeja solicitud a entregar']);
        Permission::create(['name' => 'Ver solicitudes realizadas']);


        //Permisos Recepcion ingreso productos
        Permission::create(['name' => 'Crear ingreso de productos']);
        Permission::create(['name' => 'Consultar ingreso de productos']);
        Permission::create(['name' => 'Ver inventario']);

        Permission::create(['name' => 'Ver bodega principal']);



       
    }
}

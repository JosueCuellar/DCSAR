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
		$this->call(PermisoSeeder::class);
		$this->call(RoleSeeder::class);
		$this->call(UserSeeder::class);

		DB::table('estados')->insert([
			'codigoEstado' => 'SE',
			'descripcionEstado' => 'Una requisición ha sido enviada',
			'nombreEstado' => 'Solicitud Enviada',
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

		DB::table('estados')->insert([
			'codigoEstado' => 'NA',
			'descripcionEstado' => 'No terminada',
			'nombreEstado' => 'NA',
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


		//Bodegas
		DB::table('bodegas')->insert([
			'nombreBodega' => 'Bodega principal',
			'ubicacion' => 'Nivel 1',
		]);

		DB::table('bodegas')->insert([
			'nombreBodega' => 'Bodega secundaria',
			'ubicacion' => 'Nivel 1',
		]);

		//RUBROS

		DB::table('rubros')->insert([
			['codigoPresupuestario' => '54101', 'descripRubro' => 'PRODUCTOS ALIMENTICIOS PARA PERSONAS'],
			['codigoPresupuestario' => '54102', 'descripRubro' => 'PRODUCTOS ALIMENTICIOS PARA ANIMALES'],
			['codigoPresupuestario' => '54103', 'descripRubro' => 'PRODUCTOS AGROPECUARIOS Y FORESTALES'],
			['codigoPresupuestario' => '54104', 'descripRubro' => 'PRODUCTOS TEXTILES Y VESTUARIOS'],
			['codigoPresupuestario' => '54105', 'descripRubro' => 'PRODUCTOS DE PAPEL Y CARTON'],
			['codigoPresupuestario' => '54106', 'descripRubro' => 'PRODUCTOS DE CUERO Y CAUCHO'],
			['codigoPresupuestario' => '54107', 'descripRubro' => 'PRODUCTOS QUIMICOS'],
			['codigoPresupuestario' => '54108', 'descripRubro' => 'PRODUCTOS FARMACEUTICOS Y MEDICINALES'],
			['codigoPresupuestario' => '54109', 'descripRubro' => 'LLANTAS Y NEUMATICOS'],
			['codigoPresupuestario' => '54110', 'descripRubro' => 'COMBUSTIBLE Y LUBRICANTES'],
			['codigoPresupuestario' => '54111', 'descripRubro' => 'MINERALES NO METALICOS Y PRODUCTOS DERIVADOS'],
			['codigoPresupuestario' => '54112', 'descripRubro' => 'MINERALES METALICOS Y PRODUCTOS DERIVADOS'],
			['codigoPresupuestario' => '54113', 'descripRubro' => 'MATERIALES E INSTRUMENTOS DE LABORATORIO Y USO MEDICO'],
			['codigoPresupuestario' => '54114', 'descripRubro' => 'MATERIALES DE OFICINA'],
			['codigoPresupuestario' => '54115', 'descripRubro' => 'MATERIALES INFORMATICOS'],
			['codigoPresupuestario' => '54116', 'descripRubro' => 'LIBROS, TEXTOS, UTILES DE ENSEÑANZA Y PUBLICACIONES'],
			['codigoPresupuestario' => '54117', 'descripRubro' => 'MATERIALES DE DEFENSA Y SEGURIDAD PUBLICA'],
			['codigoPresupuestario' => '54118', 'descripRubro' => 'HERRAMIENTAS, REPUESTOS Y ACCESORIOS'],
			['codigoPresupuestario' => '54119', 'descripRubro' => 'MATERIALES ELECTRICOS'],
			['codigoPresupuestario' => '54199', 'descripRubro' => 'BIENES DE USO Y CONSUMO DIVERSOS'],
			['codigoPresupuestario' => '54301', 'descripRubro' => 'MANTENIMIENTO Y REPARACION DE BIENES MUEBLES'],
			['codigoPresupuestario' => '54302', 'descripRubro' => 'MANTENIMIENTO Y REPARACION DE VEHICULOS'],
			['codigoPresupuestario' => '54313', 'descripRubro' => 'IMPRESIONES, PUBLICACIONES Y REPRODUCCIONES'],
			['codigoPresupuestario' => '54399', 'descripRubro' => 'SERVICIOS GENERALES Y ARRENDAMIENTOS DIVERSOS'],
			['codigoPresupuestario' => '61101', 'descripRubro' => 'MOBILIARIO'],
			['codigoPresupuestario' => '61102', 'descripRubro' => 'MAQUINARIA Y EQUIPO'],
			['codigoPresupuestario' => '61103', 'descripRubro' => 'EQUIPO MEDICO Y DE LABORATORIO'],
			['codigoPresupuestario' => '61104', 'descripRubro' => 'EQUIPO INFORMATIVA'],
			['codigoPresupuestario' => '61105', 'descripRubro' => 'VEHICULOS DE TRANSPORTE'],
			['codigoPresupuestario' => '61106', 'descripRubro' => 'OBRAS DE ARTE Y CULTURALES'],
			['codigoPresupuestario' => '61107', 'descripRubro' => 'LIBROS Y COLECCIONES'],
			['codigoPresupuestario' => '61108', 'descripRubro' => 'HERRAMIENTAS Y REPUESTOS PRINCIPALES',],
			['codigoPresupuestario' => '61199', 'descripRubro' => 'BIENES MUEBLES Y DIVERSOS',]
		]);
	}
}

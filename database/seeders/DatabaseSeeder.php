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
			['codigoEstado' => 'SE', 'descripcionEstado' => 'Una requisición ha sido enviada', 'nombreEstado' => 'Solicitud Enviada'],
			['codigoEstado' => 'SA', 'descripcionEstado' => 'Una requisición ha sido aprobada', 'nombreEstado' => 'Solicitud Aprobada'],
			['codigoEstado' => 'SR', 'descripcionEstado' => 'Una requisición ha sido rechazada', 'nombreEstado' => 'Solicitud Rechazada'],
			['codigoEstado' => 'SEN', 'descripcionEstado' => 'Una requisición ha sido entregada', 'nombreEstado' => 'Solicitud Entregada'],
			['codigoEstado' => 'NA', 'descripcionEstado' => 'No terminada', 'nombreEstado' => 'Solicitud Inicializada',]
		]);

	// 	//Medidas
	// 	DB::table('medidas')->insert([
	// 		['nombreMedida' => 'Bolsa 1/2 Kg.'],
	// 		['nombreMedida' => 'Kilo'],
	// 		['nombreMedida' => 'Resma'],
	// 		['nombreMedida' => 'Paq/100 U.'],
	// 		['nombreMedida' => 'Unidad'],
	// 		['nombreMedida' => 'Pliegos'],
	// 		['nombreMedida' => 'Caja'],
	// 		['nombreMedida' => 'Paq/ 200'],
	// 		['nombreMedida' => 'Rollo'],
	// 		['nombreMedida' => 'Galon'],
	// 		['nombreMedida' => 'Millares'],
	// 		['nombreMedida' => 'Bolsa/1 kls.'],
	// 		['nombreMedida' => 'b/100'],
	// 		['nombreMedida' => 'frascos'],
	// 		['nombreMedida' => 'Tarro/42.5 gs'],
	// 		['nombreMedida' => 'cubeta'],
	// 		['nombreMedida' => 'Paquete 10'],
	// 		['nombreMedida' => 'Paquete 5'],
	// 		['nombreMedida' => 'Bote'],
	// 		['nombreMedida' => 'Paquete'],
	// 		['nombreMedida' => 'Litro'],
	// 		['nombreMedida' => 'Bote 200 ml'],
	// 		['nombreMedida' => 'Llanta'],
	// 		['nombreMedida' => 'Yardas'],
	// 		['nombreMedida' => 'C./100 Pares'],
	// 		['nombreMedida' => 'Pares'],
	// 		['nombreMedida' => 'Bolsa/100'],
	// 		['nombreMedida' => 'Caja 50 Unid'],
	// 		['nombreMedida' => 'Caja de 50'],
	// 		['nombreMedida' => 'Caja/ 10 U.'],
	// 		['nombreMedida' => 'Caja/ 50 U.'],
	// 		['nombreMedida' => 'Caja/ 100 U.'],
	// 		['nombreMedida' => 'Caja/ 12 U.'],
	// 		['nombreMedida' => 'C/1000 U.'],
	// 		['nombreMedida' => 'Blister'],
	// 		['nombreMedida' => 'C ./50 U'],
	// 		['nombreMedida' => 'Bolsa 1 Lb.'],
	// 		['nombreMedida' => 'Caja/12 U.'],
	// 		['nombreMedida' => '50/sets'],
	// 		['nombreMedida' => 'Paq./ 5'],
	// 		['nombreMedida' => 'Caja / 100'],
	// 		['nombreMedida' => 'Caja / 12'],
	// 		['nombreMedida' => 'Cartucho'],
	// 		['nombreMedida' => 'Juego'],
	// 		['nombreMedida' => 'Paque./25'],
	// 		['nomebreMendia' => "Paquete/7"],
	// 		['nomebreMendia' => "Paquete/25"]
	// 	]);




	// 	//Bodegas
	// 	DB::table('bodegas')->insert([
	// 		['nombreBodega' => 'Bodega principal', 'ubicacion' => 'Nivel 1'],
	// 		['nombreBodega' => 'Bodega secundaria', 'ubicacion' => 'Nivel 1']
	// 	]);

	// 	//RUBROS

	// 	DB::table('rubros')->insert([
	// 		['codigoPresupuestario' => '54101', 'descripRubro' => 'PRODUCTOS ALIMENTICIOS PARA PERSONAS'],
	// 		['codigoPresupuestario' => '54102', 'descripRubro' => 'PRODUCTOS ALIMENTICIOS PARA ANIMALES'],
	// 		['codigoPresupuestario' => '54103', 'descripRubro' => 'PRODUCTOS AGROPECUARIOS Y FORESTALES'],
	// 		['codigoPresupuestario' => '54104', 'descripRubro' => 'PRODUCTOS TEXTILES Y VESTUARIOS'],
	// 		['codigoPresupuestario' => '54105', 'descripRubro' => 'PRODUCTOS DE PAPEL Y CARTON'],
	// 		['codigoPresupuestario' => '54106', 'descripRubro' => 'PRODUCTOS DE CUERO Y CAUCHO'],
	// 		['codigoPresupuestario' => '54107', 'descripRubro' => 'PRODUCTOS QUIMICOS'],
	// 		['codigoPresupuestario' => '54108', 'descripRubro' => 'PRODUCTOS FARMACEUTICOS Y MEDICINALES'],
	// 		['codigoPresupuestario' => '54109', 'descripRubro' => 'LLANTAS Y NEUMATICOS'],
	// 		['codigoPresupuestario' => '54110', 'descripRubro' => 'COMBUSTIBLE Y LUBRICANTES'],
	// 		['codigoPresupuestario' => '54111', 'descripRubro' => 'MINERALES NO METALICOS Y PRODUCTOS DERIVADOS'],
	// 		['codigoPresupuestario' => '54112', 'descripRubro' => 'MINERALES METALICOS Y PRODUCTOS DERIVADOS'],
	// 		['codigoPresupuestario' => '54113', 'descripRubro' => 'MATERIALES E INSTRUMENTOS DE LABORATORIO Y USO MEDICO'],
	// 		['codigoPresupuestario' => '54114', 'descripRubro' => 'MATERIALES DE OFICINA'],
	// 		['codigoPresupuestario' => '54115', 'descripRubro' => 'MATERIALES INFORMATICOS'],
	// 		['codigoPresupuestario' => '54116', 'descripRubro' => 'LIBROS, TEXTOS, UTILES DE ENSEÑANZA Y PUBLICACIONES'],
	// 		['codigoPresupuestario' => '54117', 'descripRubro' => 'MATERIALES DE DEFENSA Y SEGURIDAD PUBLICA'],
	// 		['codigoPresupuestario' => '54118', 'descripRubro' => 'HERRAMIENTAS, REPUESTOS Y ACCESORIOS'],
	// 		['codigoPresupuestario' => '54119', 'descripRubro' => 'MATERIALES ELECTRICOS'],
	// 		['codigoPresupuestario' => '54199', 'descripRubro' => 'BIENES DE USO Y CONSUMO DIVERSOS'],
	// 		['codigoPresupuestario' => '54301', 'descripRubro' => 'MANTENIMIENTO Y REPARACION DE BIENES MUEBLES'],
	// 		['codigoPresupuestario' => '54302', 'descripRubro' => 'MANTENIMIENTO Y REPARACION DE VEHICULOS'],
	// 		['codigoPresupuestario' => '54313', 'descripRubro' => 'IMPRESIONES, PUBLICACIONES Y REPRODUCCIONES'],
	// 		['codigoPresupuestario' => '54399', 'descripRubro' => 'SERVICIOS GENERALES Y ARRENDAMIENTOS DIVERSOS'],
	// 		['codigoPresupuestario' => '61101', 'descripRubro' => 'MOBILIARIO'],
	// 		['codigoPresupuestario' => '61102', 'descripRubro' => 'MAQUINARIA Y EQUIPO'],
	// 		['codigoPresupuestario' => '61103', 'descripRubro' => 'EQUIPO MEDICO Y DE LABORATORIO'],
	// 		['codigoPresupuestario' => '61104', 'descripRubro' => 'EQUIPO INFORMATIVA'],
	// 		['codigoPresupuestario' => '61105', 'descripRubro' => 'VEHICULOS DE TRANSPORTE'],
	// 		['codigoPresupuestario' => '61106', 'descripRubro' => 'OBRAS DE ARTE Y CULTURALES'],
	// 		['codigoPresupuestario' => '61107', 'descripRubro' => 'LIBROS Y COLECCIONES'],
	// 		['codigoPresupuestario' => '61108', 'descripRubro' => 'HERRAMIENTAS Y REPUESTOS PRINCIPALES',],
	// 		['codigoPresupuestario' => '61199', 'descripRubro' => 'BIENES MUEBLES Y DIVERSOS',]
	// 	]);
	}
}

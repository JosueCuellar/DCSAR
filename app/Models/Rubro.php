<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
	use HasFactory;
	protected $fillable = [
		'codigoPresupuestario',
		// 'estado_id',
		'descripRubro'
	];
		
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora


	// public function estado(){
	//     return $this->belongsTo(Estado::class);
	// }
}

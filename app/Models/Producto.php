<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

	use HasFactory;
	protected $fillable = [
		'codProducto',
		'descripcion',
		'observacion',
		'imagen',
		'marca_id',
		'medida_id',
		'rubro_id',
		'costoPromedio'
		// 'estado_id'
	];
		
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora


	public function marca()
	{
		return $this->belongsTo(Marca::class);
	}

	public function medida()
	{
		return $this->belongsTo(Medida::class);
	}

	public function rubro()
	{
		return $this->belongsTo(Rubro::class);
	}
	// public function estado()
	// {
	//     return $this->belongsTo(Estado::class);
	// }

}

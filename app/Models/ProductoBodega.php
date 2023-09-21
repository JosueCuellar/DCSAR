<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoBodega extends Model
{
	use HasFactory;
	protected $fillable = [
		'producto_id',
		'bodega_id',
		'cantidadDisponible',
	];
		
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora


	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}

	public function bodega()
	{
		return $this->belongsTo(Bodega::class);
	}
}

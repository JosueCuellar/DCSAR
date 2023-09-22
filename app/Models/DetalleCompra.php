<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
	use HasFactory;
	protected $fillable = [
		'producto_id',
		'recepcion_compra_id',
		'cantidadIngreso',
		'precioUnidad',
		'fechaVencimiento',
	];
	
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

	public function recepcionCompra()
	{
		return $this->belongsTo(RecepcionCompra::class);
	}
	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}
	// public function lote()
	// {
	//     return $this->hasOne(Lote::class);
	// }

}

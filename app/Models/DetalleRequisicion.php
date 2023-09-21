<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRequisicion extends Model
{
	use HasFactory;
	protected $fillable = [
		'cantidad',
		'precioPromedio',
		'total'
	];

		
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}
	// public function requisicionProducto()
	// {
	//     return $this->belongsTo(RequisicionProducto::class);
	// }
	public function requisicionProducto()
	{
		return $this->belongsTo('App\Models\RequisicionProducto', 'requisicion_id');
	}
}

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

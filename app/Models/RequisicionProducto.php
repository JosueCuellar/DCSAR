<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisicionProducto extends Model
{
	use HasFactory;
	protected $fillable = [
		'fechaRequisicion',
		'nCorrelativo',
		'estado_id',
		'descripcion',
		'observacion'
	];
	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'detalle_requisicions');
	}

	public function estado()
	{
		return $this->belongsTo(Estado::class);
	}

	public function scopeFechaRequisicion($query, $fechaRequisicion)
	{
		if ($fechaRequisicion) {
			return $query->where('fechaRequisicion', $fechaRequisicion);
		}
	}

	public function detallesRequisicion()
	{
		return $this->hasMany(DetalleRequisicion::class, 'requisicion_id');
	}

	public function detalleRequisicions()
	{
		return $this->hasMany('App\Models\DetalleRequisicion', 'requisicion_id');
	}

	/**
	 * Obtener el usuario que realizó la requisición de productos.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}

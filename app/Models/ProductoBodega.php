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

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}

	public function bodega()
	{
		return $this->belongsTo(Bodega::class);
	}
}

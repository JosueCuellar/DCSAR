<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
	protected $fillable = [
		'codProducto',
		'descripcion',
		'observacion',
		'stock'
	];
		
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

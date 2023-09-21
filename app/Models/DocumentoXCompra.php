<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoXCompra extends Model
{
	use HasFactory;
	protected $fillable = [
		'nombreDocumento',
		'recepcion_compra_id'
	];

		
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

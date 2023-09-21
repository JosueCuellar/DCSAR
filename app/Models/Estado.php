<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
	use HasFactory;
	protected $fillable = [
		'codigoEstado',
		'nombreEstado',
		'descripcionEstado'
	];

		
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

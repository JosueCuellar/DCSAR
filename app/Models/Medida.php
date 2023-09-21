<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
	use HasFactory;
	protected $fillable = [
		'nombreMedida'
	];
		
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

}

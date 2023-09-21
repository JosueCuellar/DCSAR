<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
	use HasFactory;
	protected $fillable = [
		'nombre'
	];
		
	protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora

	// public function productos()
	// {
	//     return $this->hasMany(Producto::class);
	// }
}

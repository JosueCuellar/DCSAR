<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadOrganizativa extends Model
{
	use HasFactory;
	protected $fillable = [
		'nombreUnidadOrganizativa',
		'descripUnidadOrganizativa'
	];
	
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora


	public function users()
	{
		return $this->hasMany('App\Models\User', 'unidad_organizativa_id');
	}
}

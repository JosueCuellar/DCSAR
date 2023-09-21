<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;
	use HasRoles;
	protected $table = 'usuarios';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];
		
	// protected $dateFormat = 'd/m/Y H:i:s'; // Configura el formato de fecha y hora


	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Obtener todas las requisiciones de productos realizadas por el usuario.
	 */
	public function requisiciones()
	{
		return $this->hasMany(RequisicionProducto::class);
	}

	public function unidadOrganizativa()
	{
		return $this->belongsTo('App\Models\UnidadOrganizativa', 'unidad_organizativa_id');
	}
}

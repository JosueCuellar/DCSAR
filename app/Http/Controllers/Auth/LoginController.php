<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Maneja las acciones después de que un usuario se autentica correctamente.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	protected function authenticated(Request $request, $user)
	{
		// Verifica si el usuario tiene el rol de 'Super Administrador'
		if ($user->hasRole('Super Administrador')) {
			// Redirecciona al panel de control del administrador superusuario
			return redirect()->route('dashboardAdmin');
		}
		// Redirecciona al destino originalmente intentado antes de la autenticación
		return redirect()->intended($this->redirectPath());
	}
}

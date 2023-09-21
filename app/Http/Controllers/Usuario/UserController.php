<?php

namespace App\Http\Controllers\Usuario;


use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Models\Rol;
use App\Models\UnidadOrganizativa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

	/**
	 * Muestra un listado de todos los registros de usuarios almacenados en la base de datos.
	 *
	 * @return Illuminate\View\View La vista del índice de usuarios con los registros almacenados.
	 */
	public function index()
	{
		try {
			// Recuperar todos los registros de usuarios
			$usuarios = User::all();

			// Enviar los registros a la vista del índice de usuarios
			return view('usuario.usuario.index', compact('usuarios'));
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario para crear un nuevo registro de usuario.
	 *
	 *
	 * @return Illuminate\View\View La vista del formulario de creación de usuarios con los datos necesarios.
	 */
	public function create()
	{
		try {
			// Recuperar todos los roles y unidades organizativas
			$roles = Rol::all();
			$unidadesOrganizativas = UnidadOrganizativa::all();

			// Enviar los roles y unidades organizativas a la vista del formulario de creación de usuarios
			return view('usuario.usuario.create', compact('unidadesOrganizativas', 'roles'));
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Almacena un nuevo registro de usuario en la base de datos.
	 *.
	 *
	 * @param UserRequest $request La solicitud HTTP con los datos del formulario.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de usuarios con un mensaje de estado.
	 */
	public function store(UserRequest $request)
	{
		try {
			// Crear y almacenar un nuevo objeto de usuario
			$usuario = new User();
			$usuario->name = $request->name;
			$usuario->email = $request->email;
			$usuario->unidad_organizativa_id = $request->unidad_organizativa_id;
			$usuario->password = Hash::make($request->password);
			$usuario->assignRole($request->input('role'));
			$usuario->save();

			// Redirigir al listado de usuarios con un mensaje de estado
			return redirect()->route('usuario.index')->with('status', 'Usuario agregado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario para editar un registro de usuario existente.
	 *
	 *
	 * @param User $usuario El objeto del usuario a editar.
	 * @return Illuminate\View\View La vista del formulario de edición de usuarios con los datos necesarios.
	 */
	public function edit(User $usuario)
	{
		try {
			// Recuperar roles y unidades organizativas
			$roles = Rol::all();
			$unidadesOrganizativas = UnidadOrganizativa::all();

			// Recuperar la unidad organizativa actual y el rol actual del usuario
			$currentUnidadOrganizativa = $usuario->unidad_organizativa_id;
			$currentRole = $usuario->roles->first();

			// Enviar los datos a la vista del formulario de edición de usuarios
			return view('usuario.usuario.edit', compact('usuario', 'roles', 'currentRole', 'unidadesOrganizativas', 'currentUnidadOrganizativa'));
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza un registro de usuario en la base de datos.
	 *
	 *
	 * @param UserRequest $request La solicitud HTTP con los datos del formulario.
	 * @param User $usuario El objeto del usuario a actualizar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de usuarios con un mensaje de estado.
	 */
	public function update(UserRequest $request, User $usuario)
	{
		try {
			// Actualizar propiedades del usuario
			$usuario->name = $request->name;
			$usuario->email = $request->email;

			// Actualizar contraseña si se proporcionó una nueva
			if (!empty($request->input('password'))) {
				$usuario->password = Hash::make($request->password);
			}

			$usuario->unidad_organizativa_id = $request->input('unidad_organizativa_id');

			// Guardar los cambios en el usuario
			$usuario->save();

			// Sincronizar roles del usuario
			$usuario->syncRoles([$request->input('role')]);

			// Redirigir al listado de usuarios con un mensaje de estado
			return redirect()->route('usuario.index')->with('status', 'Usuario actualizado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un registro de usuario de la base de datos.
	 *
	 * @param User $usuario El objeto del usuario a eliminar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de usuarios con un mensaje de estado.
	 */
	public function destroy(User $usuario)
	{
		try {
			// Eliminar el usuario
			$usuario->delete();

			// Redirigir al listado de usuarios con un mensaje de estado
			return redirect()->route('usuario.index')->with('delete', 'Usuario eliminado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otras tablas lo utilizan: ' . $e->getMessage());
		}
	}
}

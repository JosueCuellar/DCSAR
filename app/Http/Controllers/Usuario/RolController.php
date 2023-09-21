<?php

namespace App\Http\Controllers\Usuario;


use App\Http\Controllers\Controller;

use App\Http\Requests\RolRequest;
use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{

	/**
	 * Muestra la vista de asignación de roles a usuarios.
	 *
	 *
	 * @return Illuminate\View\View La vista de asignación de roles a usuarios con la lista de roles disponibles.
	 */
	public function indexRolesAssing()
	{
		try {
			// Recuperar todos los roles disponibles en la base de datos
			$roles = Rol::all();

			// Mostrar la vista de asignación de roles a usuarios con la lista de roles
			return view('usuario.roles.indexAssign', compact('roles'));
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario de asignación de permisos a un rol específico.
	 *
	 * @param Rol $role El objeto del rol al que se van a asignar los permisos.
	 * @return Illuminate\View\View El formulario de asignación de permisos con el rol y la lista de permisos disponibles.
	 */
	public function showAssignPermissionsForm(Rol $role)
	{
		try {
			// Recuperar todos los permisos disponibles en la base de datos
			$permissions = Permiso::all();
			// Mostrar el formulario de asignación de permisos con el rol y la lista de permisos
			return view('usuario.roles.assign-permissions', compact('role', 'permissions'));
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Asigna los permisos seleccionados a un rol específico.
	 *
	 *
	 * @param Request $request La solicitud HTTP con los permisos seleccionados.
	 * @param Rol $role El objeto del rol al que se van a asignar los permisos.
	 * @return Illuminate\Http\RedirectResponse La redirección a la ruta de asignación de roles con un mensaje de estado.
	 */
	public function assignPermissions(Request $request, Rol $role)
	{
		try {
			// Sincronizar los permisos seleccionados con el rol dado
			$role->syncPermissions($request->input('permissions'));

			// Redirigir a la ruta 'roles.indexAssign' con un mensaje de estado
			return redirect()->route('roles.indexAssign')->with('status', 'Permisos asignados correctamente');
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra la lista de roles disponibles.
	 *
	 *
	 * @return Illuminate\View\View La vista con la lista de roles disponibles.
	 */
	public function indexRoles()
	{
		try {
			// Recuperar todos los roles disponibles en la base de datos
			$roles = Rol::all();

			// Mostrar la lista de roles en la vista 'usuario.roles.indexRoles'
			return view('usuario.roles.indexRoles', compact('roles'));
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario para crear un nuevo rol.
	 *
	 *
	 * @return Illuminate\View\View La vista con el formulario para crear un nuevo rol.
	 */
	public function createRoles()
	{
		try {
			// Mostrar la vista 'usuario.roles.create' para crear un nuevo rol
			return view('usuario.roles.create');
		} catch (\Exception $e) {
			// En caso de error, redireccionar a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Almacena un nuevo rol en la base de datos.
	 *
	 * @param RolRequest $request El objeto de solicitud que contiene los detalles del nuevo rol.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de registros con un mensaje de estado.
	 */
	public function storeRoles(RolRequest $request)
	{
		try {
			// Crear y almacenar un nuevo objeto Rol en la base de datos
			$rol = new Rol();
			$rol->name = $request->name;
			$rol->save();

			// Redirigir al listado de registros de roles con un mensaje de estado
			return redirect()->route('rol.index')->with('status', 'Rol agregado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error, no se puede crear: ' . $e->getMessage());
		}
	}

	/**
	 * Muestra el formulario de edición para un rol existente.
	 *
	 *
	 * @param Rol $rol El objeto del rol que se va a editar.
	 * @return Illuminate\View\View La vista de edición con los detalles del rol.
	 */
	public function editRoles(Rol $rol)
	{
		try {
			// Mostrar el formulario de edición para un rol existente
			return view('usuario.roles.edit', compact('rol'));
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	/**
	 * Actualiza los detalles de un rol en la base de datos.
	 *
	 *
	 * @param RolRequest $request La solicitud HTTP con los datos del rol actualizado.
	 * @param Rol $rol El objeto del rol que se va a actualizar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de roles con un mensaje de estado.
	 */
	public function updateRoles(RolRequest $request, Rol $rol)
	{
		try {
			// Actualizar los detalles del rol utilizando los datos de la solicitud
			$rol->name = $request->name;
			$rol->save();

			// Redirigir al listado de roles con un mensaje de estado
			return redirect()->route('rol.index')->with('status', 'Rol actualizado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	/**
	 * Elimina un rol de la base de datos.
	 *
	 *
	 * @param Rol $rol El objeto del rol que se va a eliminar.
	 * @return Illuminate\Http\RedirectResponse La redirección al listado de roles con un mensaje de estado.
	 */
	public function destroyRoles(Rol $rol)
	{
		// Verificar si hay usuarios que tienen asignado el rol
		if ($rol->users()->count() > 0) {
			// Si hay usuarios con el rol asignado, mostrar un mensaje de error
			return redirect()->back()->with('catch', 'No se puede eliminar el rol porque hay usuarios que lo tienen asignado');
		}
		try {
			// Eliminar el rol de la base de datos
			$rol->delete();

			// Redirigir al listado de roles con un mensaje de estado
			return redirect()->route('rol.index')->with('delete', 'Rol eliminado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
	public function indexRolesAssing()
	{
		try {
			$roles = Role::all();
			return view('administrador.roles.indexAssign', compact('roles'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function showAssignPermissionsForm(Role $role)
	{
		try {
			$permissions = Permission::all();
			return view('administrador.roles.assign-permissions', compact('role', 'permissions'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function assignPermissions(Request $request, Role $role)
	{
		try {
			$role->syncPermissions($request->input('permissions'));
			return redirect()->route('roles.indexAssign');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	public function indexRoles()
	{
		try {
			$roles = Role::all();
			return view('administrador.roles.indexRoles', compact('roles'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Envia un arreglo de estados
	public function createRoles()
	{
		try {
			return view('administrador.roles.create');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function storeRoles(RolRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$rol = new Role();
			$rol->name = $request->name;
			$rol->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('rol.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Ha ocurrido un error no se puede crear' . $e->getMessage());
		}
	}


	//Función que permite la edición de un registro almacenado
	public function editRoles(Role $rol)
	{
		try {
			return view('administrador.roles.edit', compact('rol'));
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Función que actualiza un registro
	public function updateRoles(RolRequest $request, Role $rol)
	{
		try {
			$rol->name = $request->name;
			$rol->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('rol.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar' . $e->getMessage());
		}
	}


	//Función que elimina un registro
	public function destroyRoles(Role $rol)
	{
			// Verificar si hay usuarios que tienen asignado el rol
			if ($rol->users()->count() > 0) {
					// Si hay usuarios con el rol asignado, mostrar un mensaje de error
					return redirect()->back()->with('msg', 'No se puede eliminar el rol porque hay usuarios que lo tienen asignado');
			}
	
			try {
					$rol->delete();
					return redirect()->route('rol.index')->with('delete', 'Registro eliminado');
			} catch (\Exception $e) {
					return redirect()->back()->with('msg', 'Ha occurrido un error' . $e->getMessage());
			}
	}
	
}

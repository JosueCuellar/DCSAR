<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\UnidadOrganizativa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	//



	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{
		$usuarios = User::all();

		return view('administrador.usuario.index', compact('usuarios'));
	}

	//Envia un arreglo de estados
	public function create()
	{
		//    $estados = Estado::all();
		$roles = Role::all();
		$unidadesOrganizativas = UnidadOrganizativa::all();
		return view('administrador.usuario.create', compact('unidadesOrganizativas', 'roles'));
	}

	//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
	//Se hace uso de la clase Request para los mensajes de validación
	public function store(UserRequest $request)
	{
		try {
			//Se crea y almacena un nuevo objeto
			$usuario = new User();
			$usuario->name = $request->name;
			$usuario->email = $request->email;
			$usuario->unidad_organizativa_id = $request->unidad_organizativa_id;
			$usuario->password = Hash::make($request->password);
			$usuario->assignRole($request->input('role'));

			$usuario->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('usuario.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que permite la edición de un registro almacenado
	public function edit(User $usuario)
	{
		try {
			$roles = Role::all();
			$unidadesOrganizativas = UnidadOrganizativa::all();
			$currentUnidadOrganizativa = $usuario->unidad_organizativa_id;
			$currentRole = $usuario->roles->first();
			return view('administrador.usuario.edit', compact('usuario', 'roles', 'currentRole', 'unidadesOrganizativas', 'currentUnidadOrganizativa'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que actualiza un registro
	public function update(UserRequest $request, User $usuario)
	{
		try {
			$usuario->name = $request->name;
			$usuario->email = $request->email;
			if (!empty($request->input('password'))) {
				$usuario->password = Hash::make($request->password);
			}
			$usuario->unidad_organizativa_id = $request->input('unidad_organizativa_id');

			$usuario->save();
			$usuario->syncRoles([$request->input('role')]);

			//Se redirige al listado de todos los registros
			return redirect()->route('usuario.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
		}
	}


	//Función que elimina un registro
	public function destroy(User $usuario)
	{

		try {
			$usuario->delete();
			return redirect()->route('usuario.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utilizar');
		}
	}



	public function indexRolesAssing()
	{
		$roles = Role::all();
		return view('administrador.roles.indexAssign', compact('roles'));
	}

	public function showAssignPermissionsForm(Role $role)
	{
		$permissions = Permission::all();
		return view('administrador.roles.assign-permissions', compact('role', 'permissions'));
	}

	public function assignPermissions(Request $request, Role $role)
	{
		$role->syncPermissions($request->input('permissions'));
		return redirect()->route('roles.indexAssign');
	}

	public function indexRoles()
	{
		$roles = Role::all();
		return view('administrador.roles.indexRoles', compact('roles'));
	}

		//Envia un arreglo de estados
		public function createRoles()
		{
			return view('administrador.roles.create');
		}
	
		//Función que permite la creación de un nuevo registro que será almacenado dentro de la base de datos
		//Se hace uso de la clase Request para los mensajes de validación
		public function storeRoles(Request $request)
		{
			try {
				//Se crea y almacena un nuevo objeto
				$rol = new Role();
				$rol->name = $request->name;
				$rol->save();
				//Se redirige al listado de todos los registros
				return redirect()->route('rol.index')->with('status', 'Registro correcto');
			} catch (\Exception $e) {
				return $e->getMessage();
			}
		}


			//Función que permite la edición de un registro almacenado
	public function editRoles(Role $rol)
	{
		try {
			return view('administrador.roles.edit', compact('rol'));
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//Función que actualiza un registro
	public function updateRoles(Request $request, Role $rol)
	{
		try {
			$rol->name = $request->name;
			$rol->save();
			//Se redirige al listado de todos los registros
			return redirect()->route('rol.index')->with('status', 'Registro correcto');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'Error no se puede actualizar');
		}
	}


	//Función que elimina un registro
	public function destroyRoles(Role $rol)
	{

		try {
			$rol->delete();
			return redirect()->route('rol.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utilizar');
		}
	}

}

<?php

namespace App\Http\Controllers\Usuario;


use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Models\UnidadOrganizativa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

	//Función que trae un listado de todos los registros de la base de datos, los almacena y envía a la vista del index
	public function index()
	{

		try {
			$usuarios = User::all();

			return view('usuario.usuario.index', compact('usuarios'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
	}

	//Envia un arreglo de estados
	public function create()
	{
		//    $estados = Estado::all();
		try {
			$roles = Role::all();
			$unidadesOrganizativas = UnidadOrganizativa::all();
			return view('usuario.usuario.create', compact('unidadesOrganizativas', 'roles'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
		}
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
			return redirect()->back()->with('msg', 'Ha ocurrido un error ' . $e->getMessage());
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
			return view('usuario.usuario.edit', compact('usuario', 'roles', 'currentRole', 'unidadesOrganizativas', 'currentUnidadOrganizativa'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error ' . $e->getMessage());
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
			return redirect()->back()->with('msg', 'Error no se puede actualizar' . $e->getMessage());
		}
	}


	//Función que elimina un registro
	public function destroy(User $usuario)
	{

		try {
			$usuario->delete();
			return redirect()->route('usuario.index')->with('delete', 'Registro eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('msg', 'El registro no se puede eliminar, otra tabla lo utilizar' . $e->getMessage());
		}
	}

}

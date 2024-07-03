<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Rol;
use App\Models\UnidadOrganizativa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
	//Muestra un listado de todos los registros de usuarios almacenados en la base de datos.
	public function index()
	{
		return view('usuario.usuario.index');
	}

	//Envia datos JSON de usuarios
	public function getUsuarios()
	{
		$usuarios = User::all();
		$data = [];
		foreach ($usuarios as $usuario) {
			$roles = $usuario->getRoleNames()->implode(', ');
			$unidadOrganizativa = $usuario->unidadOrganizativa->nombreUnidadOrganizativa ?? '';
			$data[] = [
				'id' => $usuario->id, 'name' => $usuario->name, 'email' => $usuario->email, 'roles' => $roles, 'unidad_organizativa' => $unidadOrganizativa,
			];
		}
		return DataTables::of($data)->make(true);
	}

	//Muestra el formulario para crear un nuevo registro de usuario.
	public function create()
	{
		$roles = Rol::all();
		$unidadesOrganizativas = UnidadOrganizativa::all();
		return view('usuario.usuario.create', compact('unidadesOrganizativas', 'roles'));
	}

	// Almacena un nuevo registro de usuario en la base de datos.
	public function store(UserRequest $request)
	{
		$usuario = new User();
		$usuario->name = $request->name;
		$usuario->email = $request->email;
		$usuario->unidad_organizativa_id = $request->unidad_organizativa_id;
		$usuario->password = Hash::make($request->password);
		$usuario->assignRole($request->input('role'));
		$usuario->save();
		return redirect()->route('usuario.index')->with('status', 'Usuario agregado');
	}

	//Muestra el formulario para editar un registro de usuario existente.
	public function edit(User $usuario)
	{
		try {
			$roles = Rol::all();
			$unidadesOrganizativas = UnidadOrganizativa::all();
			$currentUnidadOrganizativa = $usuario->unidad_organizativa_id;
			$currentRole = $usuario->roles->first();
			return view('usuario.usuario.edit', compact('usuario', 'roles', 'currentRole', 'unidadesOrganizativas', 'currentUnidadOrganizativa'));
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'Ha ocurrido un error: ' . $e->getMessage());
		}
	}

	// Actualiza un registro de usuario en la base de datos.
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
			return redirect()->route('usuario.index')->with('status', 'Usuario actualizado');
		} catch (\Exception $e) {
			// En caso de error, redirigir a la página anterior con un mensaje de error
			return redirect()->back()->with('catch', 'Error, no se puede actualizar: ' . $e->getMessage());
		}
	}

	// Elimina un registro de usuario de la base de datos.
	public function destroy(User $usuario)
	{
		try {
			$usuario->delete();
			return redirect()->route('usuario.index')->with('delete', 'Usuario eliminado');
		} catch (\Exception $e) {
			return redirect()->back()->with('catch', 'El registro no se puede eliminar, otras tablas lo utilizan: ' . $e->getMessage());
		}
	}
}

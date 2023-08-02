<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|eliminar-rol', ['only' => ['index','store']]);
        $this->middleware('permission:crear-rol', ['only' => ['create','store']]);
        $this->middleware('permission:editar-rol', ['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-rol', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            $roles = Role::all();
            foreach ($roles as $role){
              $role->permissions->pluck('name');
            }
          return Inertia::render('Roles/IndexView', [
            'roles' => $roles,
          ]);
        }catch (\Exception $e){
          return back()->withErrors(['validacion' => 'Ha ocurrido un error '. $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        return Inertia::render('Roles/RegisterRoleView', [
          'permisos' => Permission::all(),
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
          'nombre' => 'required|unique:roles,name',
          'permisos' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }

        $role = Role::create(['name' => $input['nombre']]);
        $role->syncPermissions($input['permisos']);
        $role->save();
        $roles = Role::all();
        foreach ($roles as $role){
            Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                ->where("role_has_permissions.role_id",$role->id)
                ->get();
        }

      return redirect()->route('listar_roles')->with('message', 'Rol de Usuario Registrado con Éxito');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return response()->json(['success'=>true, 'rolePermisos' => $rolePermissions]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $role->permissions->pluck('name');
        $permisos = Permission::all();
        foreach ($permisos as $permiso){
          foreach ($role->permissions as $perm){
            if($permiso->name === $perm->name){
              $permiso->checked = true;
            }
          }
        }

        return Inertia::render('Roles/EditRoleView', [
          'permisos' => $permisos,
          'role' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
          'nombre' => 'required',
          'permisos' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        $role = Role::find($id);
        $role->name = $input['nombre'];
        $role->save();
        $role->syncPermissions($input['permisos']);
        return redirect()->route('listar_roles')->with('message', 'Rol de Usuario Actualizado con Éxito');
    }


    public function destroy($id)
    {
      DB::table("roles")->where('id',$id)->delete();
      return redirect()->route('listar_roles')->with('message', 'Rol de Usuario Elimando con Éxito');
    }
}

<?php

namespace App\Http\Controllers;


use App\Models\Config;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Excel;
use App\Imports\UsersImport;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|eliminar-usuario', ['only' => ['index']]);
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|editar-usuario(perfil)|eliminar-usuario', ['only' => ['show']]);
        $this->middleware('permission:crear-usuario', ['only' => ['create','store','import']]);
        $this->middleware('permission:editar-usuario|editar-usuario(perfil)', ['only' => ['update']]);
        $this->middleware('permission:eliminar-usuario', ['only' => ['destroy']]);
        $this->middleware('permission:banear-usuario', ['only' => ['enableDisable']]);
    }

    public function index(): \Inertia\Response
    {
        ConexionController::conecta(Auth::user()->id);
        $users = User::all();
        foreach ($users as $user) {
            $roles = $user->roles;
            $user->conectado = ConexionController::verificaConexionUsuario($user->id);
            foreach ($roles as $role){
                $role->permissions->pluck('name');
            }
        }
        return Inertia::render('Usuarios/IndexView', [
          'users' => $users
        ]);
    }

    public function create(): \Inertia\Response
    {
      return Inertia::render('Usuarios/RegisterUserView', [
        'roles' => Role::all(),
      ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'correo' => 'required|email',
            'telefono' => 'required',
            'entidad' => 'required',
            'ocupacion' => 'required',
            'rolUsuario' => 'required',
            'password' => 'required',
            'password2' => 'required|same:password',
        ]);
        if($validator->fails()){
            return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        try {
            $user = new User();
            $user->name = $input['nombre'];
            $user->email = $input['correo'];
            $user->telefono = $input['telefono'];
            $user->entidad = $input['entidad'];
            $user->ocupacion = $input['ocupacion'];
            $user->habilitado = true;
            $user->conexion = '{}';
            $user->password = bcrypt($input['password']);
            if($request->file('avatar')){
                try {
                  $file = $filename = time().".".$request->avatar->extension();
                  $request->avatar->move(public_path("img/profile"), $filename);
                  $user->imagen = $file;
                }catch (\Exception $e){
                  return back()->withErrors(['validacion' => $e->getMessage()]);
                }
            }else{
                $user->imagen = 'user.png';
            }
            $role = Role::find($request->input('rolUsuario'));
            $user->assignRole([$role->id]);
            $user->save();
            return redirect()->route('listar_usuarios')->with('message', 'Usuario Registrado con Éxito');
        } catch (\Exception $e){
            if($e->getCode() == 23000){
              return back()->withErrors(['validacion' => 'Este usuario ya existe']);
            }
          return back()->withErrors(['validacion' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        $roles = $user->roles;
        foreach ($roles as $role){
            $role->permissions->pluck('name');
        }
        if (is_null($user)) {
            return back()->withErrors(['validacion' => 'Usuario no encontrado']);
        }
        return Inertia::render('Usuarios/ProfileUserView', [
          'usuario' => $user,
        ]);
    }

    public function edit($id): \Inertia\Response
    {
      $user = Auth::user();
      if($user->can('editar-usuario')){
        $user = User::find($id);
      }
      $roles = $user->roles;
      foreach ($roles as $role){
        $role->permissions->pluck('name');
      }
      return Inertia::render('Usuarios/EditUserView', [
        'usuario' => $user,
        'roles' => Role::all(),
      ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if($user->can('editar-usuario')){
          $user = User::find($id);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
          'nombre' => 'required',
          'correo' => 'required|email',
          'telefono' => 'required',
          'entidad' => 'required',
          'ocupacion' => 'required',
          'rolUsuario' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación', $validator->errors()]);
        }
        if($request->file('avatar')){
          try {
            $file = $filename = time().".".$request->avatar->extension();
            $request->avatar->move(public_path("img/profile"), $filename);
            $user->imagen = $file;
          }catch (\Exception){
          }
        }
        if($input['password'] && $input['password'] == $input['password2']){
          $user->password = bcrypt($input['password']);
        }else if($input['password'] && $input['password2']){
          return back()->withErrors(['validacion' => 'Las contraseñas no coinciden']);
        }
        $user->name = $input['nombre'];
        $user->email = $input['correo'];
        $user->telefono = $input['telefono'];
        $user->entidad = $input['entidad'];
        $user->ocupacion = $input['ocupacion'];
        $role = Role::find($request->input('rolUsuario'));
        $user->roles()->detach();
        $user->assignRole([$role->id]);
        $user->save();
        if(!Auth::user()->can('ver-usuario')){
          return redirect()->route('perfil_usuario', ['id' => $user->id])->with('message', 'Usuario Actualizado con Éxito');
        }
        return redirect()->route('listar_usuarios')->with('message', 'Usuario Actualizado con Éxito');
    }

    public function destroy($id)
    {
        if($id == Auth::user()->getAuthIdentifier()){
            return back()->withErrors(['validacion' => 'No puede eliminar su propio usuario']);
        }else{
            $user = User::find($id);
            if($user->imagen != 'user.png'){
                try{
                    unlink(public_path('img/profile/').$user->imagen);
                }catch (\Exception $e){
                }
            }
            $user->delete();
            return redirect()->route('listar_usuarios')->with('message', 'Usuario Eliminado con Éxito');
        }
    }

    public function enableDisable($id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        if ($user->habilitado) {
            $user->habilitado = false;
            $user->save();
            $response = 'Usuario Deshabilitado con éxito';
        }else{
            $user->habilitado = true;
            $user->save();
            $response = 'Usuario Habilitado con éxito';
        }
        return redirect()->route('listar_usuarios')->with('message', $response);
    }

  public function import(Request $request)
  {
    $usuarios = $request->archivo;
    foreach ($usuarios as $usuarioArchivo){
      $user = new User();
      $user->name = $usuarioArchivo['nombre'];
      $user->email = $usuarioArchivo['correo'];
      $user->password = bcrypt($usuarioArchivo['contrasena']);
      $user->telefono = $usuarioArchivo['telefono'];
      $user->entidad = $usuarioArchivo['entidad'];
      $user->ocupacion = $usuarioArchivo['ocupacion'];
      $user->habilitado =  true;
      $user->conexion = '{}';
      $user->imagen = 'user.png';
      $role = Role::findByName('Cliente');
      $user->assignRole([$role->id]);
      $user->save();
    }
    $users = User::all();
    foreach ($users as $user) {
      $roles = $user->roles;
      foreach ($roles as $role){
        $role->permissions->pluck('name');
      }
    }
    return redirect()->route('listar_usuarios')->with('message', 'Usuarios Importados con Éxito');
  }
}

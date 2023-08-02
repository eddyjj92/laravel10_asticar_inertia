<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'entidad' => 'required',
            'ocupacion' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Error de Validación: ', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        if($request->imagen){
            $imagen = time().'.' . explode('/', explode(':', substr($request->imagen, 0, strpos($request->imagen, ';')))[1])[1];
            Image::make($request->imagen)->save(public_path('img/profile/').$imagen);
            $input['imagen'] = $imagen;
        }
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['id'] =  $user->id;
        $success['name'] =  $user->name;
        $success['email'] = $user->email;
        $success['imagen'] = $user->imagen;
        $success['entidad'] = $user->entidad;
        $success['ocupacion'] = $user->ocupacion;
        $success['telefono'] = $user->telefono;

        return response()->json(['success' => true, 'message'=> 'Registro y Autenticación Exitosa', 'data' => $success]);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            if($user->habilitado === true){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                    $user = Auth::user();
                    $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                    $success['id'] =  $user->id;
                    $success['name'] =  $user->name;
                    $success['email'] = $user->email;
                    $success['imagen'] = $user->imagen;
                    $success['entidad'] = $user->entidad;
                    $success['ocupacion'] = $user->ocupacion;
                    $success['telefono'] = $user->telefono;
                    $success['habilitados'] = $user->telefono;
                    $roles = $user->roles;
                    foreach ($roles as $role){
                        $role->permissions->pluck('name');
                    }
                    $success['roles'] = $roles;
                    return response()->json(['success' => true, 'message'=> 'Autenticación Exitosa, '.$user->name, 'data' => $success]);
                }else{
                    return response()->json(['success' => false, 'message'=> 'Acceso Denegado'], 401);
                }
            }else{
                return response()->json(['success' => false, 'message'=> 'El usuario se encuentra deshabilitado'], 403);
            }
        }else{
            return response()->json(['success' => false, 'message'=> 'Este usuario no existe'], 404);
        }

    }
}

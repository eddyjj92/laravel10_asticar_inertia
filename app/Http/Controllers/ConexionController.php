<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConexionController extends Controller
{
    public static function conecta($id): void
    {
        $date = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $user = User::find($id);
        $data = [
            'fecha'=>$date,
            'ip'=>$ip,
        ];
        $user->conexion = $data;
        $user->save();
    }

    public static function verificaConectados()
    {
        $time = 3;
        $date = time();
        $limite = $date - $time * 60;
        $usuariosConectados = 0;
        $usuarios = User::all();
        foreach ($usuarios as $usuario){
            $conexion = $usuario->conexion;
            if(isset($conexion['fecha'])){
                if((int)$conexion['fecha'] > $limite){
                    $usuariosConectados++;
                }
            }
        }
        return $usuariosConectados;
    }

  public static function verificaConexionUsuario($id)
  {
    $time = 3;
    $date = time();
    $limite = $date - $time * 60;
    $usuariosConectados = 0;
    $usuario = User::find($id);

    $conexion = $usuario->conexion;
    if(isset($conexion['fecha'])){
      if((int)$conexion['fecha'] > $limite){
        return 'conectado';
      }else{
        return 'desconectado';
      }
    }else{
      return 'sin autenticar';
    }
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Servicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class MensajeController extends Controller
{
    function __construct()
    {
        date_default_timezone_set('America/Havana');
        $this->middleware('permission:ver-mensaje|editar-mensaje|crear-mensaje|eliminar-mensaje', ['only' => ['index','show']]);
        $this->middleware('permission:editar-mensaje', ['only' => ['update']]);
        $this->middleware('permission:eliminar-mensaje', ['only' => ['destroy']]);
    }

    public function index()
    {
      return Inertia::render('Mensajes/IndexView', [
        'mensajes' => Mensaje::all()
      ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'persona' => 'required',
            'correo' => 'required|email:filter',
            'asunto' => 'required',
            'mensaje' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        try {
            $mensaje = new Mensaje();
            $mensaje->persona = $input['persona'];
            $mensaje->correo = $input['correo'];
            $mensaje->asunto = $input['asunto'];
            $mensaje->mensaje = $input['mensaje'];
            $mensaje->estado = false;
            $mensaje->save();
        } catch (\Exception $e){
            return back()->withErrors(['validacion' => $e->getMessage()]);
        }
        return redirect()->route('home')->with('message', 'Mensaje Enviado con Éxito');
    }

    public function show($id)
    {
        $mensaje = Mensaje::find($id);
        if (is_null($mensaje)) {
            return back()->withErrors(['validacion' => 'Mensaje no encontrado.']);
        }
        $mensaje->estado = true;
        $mensaje->save();

      return Inertia::render('Mensajes/VerMensajeView', [
        'mensaje' => $mensaje
      ]);
    }

    public function destroy($id)
    {
        $mensaje = Mensaje::find($id);
        if(is_null($mensaje)) {
          return back()->withErrors(['validacion' => 'Mensaje no encontrado.']);
        }
        $mensaje->delete();
        return redirect()->route('listar_mensajes')->with('message', 'Mensaje eliminado con éxito');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class SolicitudController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-solicitud(todas)|crear-solicitud|editar-solicitud|eliminar-solicitud', ['only' => ['index','show']]);
        $this->middleware('permission:ver-solicitud(usuario)|crear-solicitud|editar-solicitud|eliminar-solicitud', ['only' => ['index','show']]);
        $this->middleware('permission:crear-solicitud', ['only' => ['create','store']]);
        $this->middleware('permission:editar-solicitud', ['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-solicitud', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = Auth::user();
        if($user->can('ver-solicitud(todas)')){
          $solicitudes = Solicitud::all();
        }else{
          $solicitudes = Solicitud::where('correo',$user->email)->get();
        }
        foreach ($solicitudes as $solicitud){
          $solicitud->servicio;
        }
        return Inertia::render('Solicitudes/IndexView', [
          'solicitudes' => $solicitudes
        ]);
    }

    public function create(): \Inertia\Response
    {
      return Inertia::render('Solicitudes/RegisterSolicitudView', [
        'servicios' => Servicio::where('habilitado', true)->get()
      ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'servicio' => 'required' ,
            'entidad'=> 'required',
            'correo'=> 'required',
            'telefono'=> 'required',
            'solicitado_por' => 'required',
            'cargo' => 'required',
            'objeto_obra'=> 'required',
            'trabajos_realizar'=> 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        $solicitud = new Solicitud();
        $solicitud->servicio_id = $input['servicio'];
        $solicitud->entidad = $input['entidad'];
        $solicitud->correo = $input['correo'];
        $solicitud->telefono = $input['telefono'];
        $solicitud->solicitado_por = $input['solicitado_por'];
        $solicitud->cargo_solicita = $input['cargo'];
        $solicitud->objeto_obra = $input['objeto_obra'];
        $solicitud->trabajos_realizar = $input['trabajos_realizar'];
        $solicitud->adicional = $input['adicional'];
        $solicitud->estado_solicitud = 'pendiente';
        $solicitud->save();
        return redirect()->route('listar_solicitudes')->with('message', 'Solicitud Registrada con Éxito');
    }


    public function show($id)
    {
        $solicitud = Solicitud::find($id);
        if (is_null($solicitud)) {
            return back()->withErrors(['validacion' => 'Solicitud de Servicio Inexistente']);
        }
        $solicitud->servicio;
        return $solicitud;
    }

    public function update(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'estado_solicitud' => 'required',
            'recibido_por' => 'required',
            'cargo_recibe' => 'required'
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        $solicitud->estado_solicitud = $input['estado_solicitud'];
        $solicitud->recibido_por = $input['recibido_por'];
        $solicitud->cargo_recibe = $input['cargo_recibe'];
        $solicitud->save();
        return redirect()->route('listar_solicitudes')->with('message','Solicitud '.$input['estado_solicitud']);
    }

    public function destroy($id)
    {
        $solicitud = Solicitud::find($id);
        $solicitud->delete();
        return redirect()->route('listar_solicitudes')->with('message','Solicitud eliminada con éxito');
    }

  public function print($id)
  {
    $solicitud = Solicitud::find($id);
    $solicitud->servicio;
    return Inertia::render('Solicitudes/PrintSolicitudView', [
      'solicitud' => $solicitud
    ]);
  }
}

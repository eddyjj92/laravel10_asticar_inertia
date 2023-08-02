<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ServicioController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-servicio|crear-servicio|editar-servicio|eliminar-servicio', ['only' => ['index']]);
        $this->middleware('permission:crear-servicio', ['only' => ['create','store']]);
        $this->middleware('permission:editar-servicio', ['only' => ['edit','update']]);
        $this->middleware('permission:habilitar-servicio', ['only' => ['enableDisable']]);
        $this->middleware('permission:eliminar-servicio', ['only' => ['destroy']]);
    }

    public function index()
    {
      return Inertia::render('Servicios/IndexView', [
        'servicios' => Servicio::all()
      ]);
    }

    public function create(): \Inertia\Response
    {
      return Inertia::render('Servicios/RegisterServiceView', []);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        try {
            $servicio = new Servicio();
            $servicio->nombre = $input['nombre'];
            $servicio->descripcion = $input['descripcion'];
            $servicio->habilitado = true;
            $servicio->save();
        } catch (\Exception $e){
            if($e->getCode() == "23000"){
              return back()->withErrors(['validacion' => 'Ya existe un servicio con el mismo nombre']);
            }
            return back()->withErrors(['validacion' => $e->getMessage()]);
        }
        return redirect()->route('listar_servicios')->with('message', 'Servicio Registrado con Éxito');
    }

    public function edit($id): \Inertia\Response
    {
      return Inertia::render('Servicios/EditServiceView', [
        'servicio' => Servicio::find($id),
      ]);
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'descripcion' => 'required',

        ]);
        if($validator->fails()){
           return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        $servicio->nombre = $input['nombre'];
        $servicio->descripcion = $input['descripcion'];
        $servicio->save();
        return redirect()->route('listar_servicios')->with('message', 'Servicio Actualizado con Éxito');
    }

    public function destroy($id)
    {
        $servicio = Servicio::find($id);
        if($servicio){
          $servicio->delete();
          return redirect()->route('listar_servicios')->with('message', 'Servicio Eliminado con Éxito');
        }
        return back()->withErrors(['validacion' => 'Este servicio no existe']);
    }

    public function enableDisable($id): \Illuminate\Http\RedirectResponse
    {
      $servicio = Servicio::find($id);
      if ($servicio->habilitado) {
        $servicio->habilitado = false;
        $servicio->save();
        $response = 'Servicio Deshabilitado con éxito';
      }else{
        $servicio->habilitado = true;
        $servicio->save();
        $response = 'Servicio Habilitado con éxito';
      }
      return redirect()->route('listar_servicios')->with('message', $response);
    }
}

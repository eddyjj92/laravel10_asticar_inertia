<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ImageController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-imagen|crear-imagen|editar-imagen|eliminar-imagen', ['only' => ['index','show']]);
        $this->middleware('permission:crear-imagen', ['only' => ['create','store']]);
        $this->middleware('permission:editar-imagen', ['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-imagen', ['only' => ['destroy']]);
    }

    public function index(): \Inertia\Response
    {
      return Inertia::render('Images/IndexView', [
        'images' => Imagen::all()
      ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'imagenes' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        try {
            foreach ($request->imagenes as $imagen){
              $image = new Imagen();
              $file = uniqid('img').".".$imagen->extension();
              $imagen->move(public_path("img/portadas"), $file);
              $image->imagen = $file;
              $image->descripcion = $file;
              $image->save();
            }
        } catch (\Exception $e){
          return back()->withErrors(['validacion' => $e->getMessage()]);
        }
        return redirect()->route('listar_imagenes')->with('message', 'Imágen Guardada con Éxito');
    }

    public function destroy(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
          'imagenes_seleccionadas' => 'required|array|min:1',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        foreach ($request->imagenes_seleccionadas as $id){
          $imagen = Imagen::find($id);
          try {
            unlink(public_path('img/portadas/').$imagen->imagen);
          }catch (\Exception){}
          $imagen->delete();
        }
        if(count($request->imagenes_seleccionadas) == 1){
          return redirect()->route('listar_imagenes')->with('message', 'Imágen Eliminada con Éxito');
        }
        return redirect()->route('listar_imagenes')->with('message', 'Imagenes Eliminadas con Éxito');
    }
}

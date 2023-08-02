<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Servicio;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class NoticiaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-noticia|crear-noticia|editar-noticia|eliminar-noticia', ['only' => ['index','store']]);
        $this->middleware('permission:crear-noticia', ['only' => ['create','store']]);
        $this->middleware('permission:editar-noticia', ['only' => ['edit','update']]);
        $this->middleware('permission:eliminar-noticia', ['only' => ['destroy']]);
    }

    public function index()
    {
        return Inertia::render('Noticias/IndexView', [
          'noticias' => Noticia::all()
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Noticias/RegisterNoticiaView', []);
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'titulo' => 'required',
            'noticia' => 'required',
        ]);
        if($validator->fails()){
          return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
        }
        try {
            $input['publicado_por'] = Auth::user()['name'];
            if($request->file('imagen')){
              try {
                $file = $filename = time().".".$request->imagen->extension();
                $request->imagen->move(public_path("img/noticias"), $filename);
                $input['imagen'] = $file;
              }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
              }
            }else{
              $input['imagen'] = 'publicacion.png';
            }
            Noticia::create($input);
        } catch (\Exception $e){
            return back()->withErrors(['validacion' => $e->getMessage()]);
        }
        return redirect()->route('listar_noticias')->with('message', 'Noticia Publicada con Éxito');
    }

    public function show($id)
    {
        $noticia = Noticia::find($id);
        if (is_null($noticia)) {
            return back()->withErrors(['validacion' => 'Noticia no encontrada.']);
        }
      return Inertia::render('Noticias/VerNoticiaView', [
        'noticia' => $noticia,
      ]);
    }

    public function edit($id): \Inertia\Response
    {
      return Inertia::render('Noticias/EditNoticiaView', [
        'noticia' => Noticia::find($id),
      ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $noticia = Noticia::find($id);
            $input = $request->all();
            $validator = Validator::make($input, [
                'titulo' => 'required',
                'noticia' => 'required',
            ]);
            if($validator->fails()){
              return back()->withErrors(['validacion' => 'Error de Validación '.$validator->errors()]);
            }
            if($request->file('imagen')){
              try {
                $file = $filename = time().".".$request->imagen->extension();
                $request->imagen->move(public_path("img/noticias"), $filename);
                if($noticia->imagen != 'publicacion.png'){
                  try {
                    unlink(public_path('img/noticias/').$noticia->imagen);
                  }catch (\Exception){}
                }
                $noticia->imagen = $file;
              }catch (\Exception $e){
                return back()->withErrors(['validacion' => $e->getMessage()]);
              }
            }
            $noticia->titulo = $input['titulo'];
            $noticia->noticia = $input['noticia'];
            $noticia->save();
            return redirect()->route('listar_noticias')->with('message', 'Noticia Actualizada con Éxito');
        }catch (\Exception $e){
            return back()->withErrors(['validacion' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        if($noticia->imagen != 'publicacion.png'){
            unlink(public_path('img/noticias/').$noticia->imagen);
        }
        $noticia->delete();
        return redirect()->route('listar_noticias')->with('message', 'Noticia Eliminada con Éxito');
    }
}

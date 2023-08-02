<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Imagen;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class ConfigController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-config|editar-config', ['only' => ['index']]);
        $this->middleware('permission:editar-config', ['only' => ['update']]);

    }

    public function index(): \Inertia\Response
    {
      return Inertia::render('Config/IndexView', [
        'configs' => Config::all()
      ]);
    }

    public function update(Request $request)
    {
        try {
            $config = Config::find($request->id);

            if($config->id == 2){
                if($request->file('imagen') && $request->file('imagen') != null) {
                    try {
                      $file = $filename = time() . "." . $request->imagen->extension();
                      $request->imagen->move(public_path("img/portadas"), $filename);
                      try {
                        unlink(public_path('img/profile/').$config->imagen);
                      }catch (\Exception){}
                    } catch (\Exception $e) {
                      return back()->withErrors(['validacion' => $e->getMessage()]);
                    }
                }
            }

            try {
              if($config->id == 2 && isset($file)){
                $subconfig = $request->config;
                $subconfig['imagen'] = $file;
                $config->config = $subconfig;
              }else if($config->id == 2 && !isset($file)){
                $subconfig = $request->config;
                $subconfig['imagen'] = $config->config['imagen'];
                $config->config = $subconfig;
              }else{
                $config->config = $request->config;
              }
              $config->save();
              return redirect()->route('listar_configs')->with('message', $config->config);
            }catch (\Exception $e){
              return back()->withErrors(['validacion' => $e->getMessage()]);
            }

        }catch (\Exception $e){
            return back()->withErrors(['validacion' => $e->getMessage()]);
        }
    }
}

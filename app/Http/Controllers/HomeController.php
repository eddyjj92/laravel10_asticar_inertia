<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Imagen;
use App\Models\Noticia;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
      return Inertia::render('Index', [
        'images' => Imagen::all(),
        'configs' => Config::all(),
        'servicios' => Servicio::where('habilitado', true)->get(),
        'noticias' => Noticia::all(),
      ]);
    }
}

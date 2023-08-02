<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Noticia;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
  public function index() {

    ConexionController::conecta(Auth::user()->id);

    return Inertia::render('Dashboard', [
      'configs' => Config::all(),
      'cantUsers' => count(User::all()),
      'conectedUsers' => ConexionController::verificaConectados(),
      'cantSolicitudes' => count(Solicitud::where('estado_solicitud','pendiente')->get()),
      'cantNoticias' => count(Noticia::all()),
    ]);
  }
}

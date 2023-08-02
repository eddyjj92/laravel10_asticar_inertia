<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserImportController;
use App\Models\Config;
use App\Models\Imagen;
use App\Models\Noticia;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::any('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('Usuarios', UserController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('solicitudes', SolicitudController::class);
    Route::resource('images', ImageController::class);
    Route::resource('noticias', NoticiaController::class);
    Route::resource('roles', RoleController::class);
    Route::controller(ConfigController::class)->group(function(){
        Route::post('config',  'update')->name('config_update');
        Route::get('configs',  'index')->name('configs_get');
    });
    Route::controller(UserImportController::class)->group(function(){
        Route::post('usuarios_importar',  'import')->name('usuarios_importar');
    });
    Route::controller(UserController::class)->group(function(){
        Route::put('usuarios_enable_disable/{id}',  'enableDisable')->name('usuarios_enable_disable');
        Route::put('usuarios_perfil/{id}',  'updatePerfil')->name('update_perfil');
    });
    Route::controller(MensajeController::class)->group(function(){
        Route::get('mensajes',  'index')->name('mensajes');
        Route::delete('mensajes/{id}',  'destroy')->name('delete_mensaje');
        Route::get('mensajes/{id}',  'show')->name('ver_mensaje');
    });
});

Route::controller(MensajeController::class)->group(function(){
    Route::post('mensajes',  'store')->name('crear_mensajes');
});

Route::controller(PublicController::class)->group(function(){
    Route::get('public_images',  function (){
        return response()->json(['success' => true, 'data' => Imagen::all()]);
    })->name('public_images');
});

Route::controller(ConfigController::class)->group(function(){
    Route::get('public_configs',  function (){
        return response()->json(['success' => true, 'data' => Config::all()]);
    })->name('public_configs');
});

Route::controller(ServicioController::class)->group(function(){
    Route::get('public_servicios',  function (){
        return response()->json(['success'=>true, 'data'=>Servicio::all()]);
    })->name('public_servicios');
});

Route::controller(NoticiaController::class)->group(function(){
    Route::get('public_noticias',  function (){
        return response()->json(['success'=>true, 'data'=>Noticia::all()]);
    })->name('public_noticias');
});

Route::get('datatables/es',  function (){
    return response()->file(public_path('datatables/es-ES.json'));
})->name('datatables_es');



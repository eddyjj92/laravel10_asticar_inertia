<?php


use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\UserController;
use App\Models\Imagen;
use App\Models\Servicio;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->group(function(){
  Route::get('/','index')->name('home');
});

Route::controller(LoginController::class)->group(function(){
  Route::get('/login','login')->name('login');
  Route::post('/login','authenticate')->name('authenticate');
  Route::get('/logout','logout')->name('authenticate');
});

Route::middleware('auth')->group( function () {

  Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
  });

  Route::controller(ConfigController::class)->group(function () {
    Route::get('configs', 'index')->name('listar_configs');
    Route::post('config/actualizar', 'update')->name('update_config');
  });

  Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'index')->name('listar_roles');
    Route::get('/roles/ver/{id}', 'show')->name('ver_roles');
    Route::get('/roles/registrar', 'create')->name('crear_roles');
    Route::get('/roles/editar/{id}', 'edit')->name('editar_roles');
    Route::post('/roles/registrar', 'store')->name('registrar_roles');
    Route::post('/roles/actualizar/{id}', 'update')->name('actualizar_roles');
    Route::delete('/roles/eliminar/{id}', 'destroy')->name('eliminar_roles');
  });

  Route::controller(UserController::class)->group(function () {
    Route::get('/usuarios', 'index')->name('listar_usuarios');
    Route::get('/usuario/perfil/{id}', 'show')->name('perfil_usuario');
    Route::get('/usuario/registrar', 'create')->name('crear_usuario');
    Route::get('/usuario/editar/{id}', 'edit')->name('editar_usuario');
    Route::post('/usuario/registrar', 'store')->name('registrar_usuario');
    Route::post('/usuario/actualizar/{id}', 'update')->name('actualizar_usuario');
    Route::post('/usuarios/importar', 'import')->name('importar_usuarios');
    Route::delete('/usuario/eliminar/{id}', 'destroy')->name('eliminar_usuario');
    Route::get('/usuario/enable_disable/{id}', 'enableDisable')->name('enable_disable_usuario');
  });

  Route::controller(ServicioController::class)->group(function () {
    Route::get('/servicios', 'index')->name('listar_servicios');
    Route::get('/servicios/ver/{id}', 'show')->name('ver_servicios');
    Route::get('/servicios/registrar', 'create')->name('crear_servicios');
    Route::get('/servicios/editar/{id}', 'edit')->name('editar_servicios');
    Route::post('/servicios/registrar', 'store')->name('registrar_servicios');
    Route::post('/servicios/actualizar/{id}', 'update')->name('actualizar_servicios');
    Route::delete('/servicios/eliminar/{id}', 'destroy')->name('eliminar_servicios');
    Route::get('/servicios/enable_disable/{id}', 'enableDisable')->name('enable_disable_servicios');
  });

  Route::controller(SolicitudController::class)->group(function () {
    Route::get('/solicitudes', 'index')->name('listar_solicitudes');
    Route::get('/solicitudes/ver/{id}', 'show')->name('ver_solicitudes');
    Route::get('/solicitudes/imprimir/{id}', 'print')->name('imprimir_solicitudes');
    Route::get('/solicitudes/registrar', 'create')->name('crear_solicitudes');
    Route::get('/solicitudes/editar/{id}', 'edit')->name('editar_solicitudes');
    Route::post('/solicitudes/registrar', 'store')->name('registrar_solicitudes');
    Route::post('/solicitudes/actualizar/{id}', 'update')->name('actualizar_solicitudes');
    Route::delete('/solicitudes/eliminar/{id}', 'destroy')->name('eliminar_solicitudes');
    Route::get('/solicitudes/enable_disable/{id}', 'enableDisable')->name('enable_disable_solicitudes');
  });

  Route::controller(NoticiaController::class)->group(function () {
    Route::get('/noticias', 'index')->name('listar_noticias');
    Route::get('/noticias/ver/{id}', 'show')->name('ver_noticias');
    Route::get('/noticias/registrar', 'create')->name('crear_noticias');
    Route::get('/noticias/editar/{id}', 'edit')->name('editar_noticias');
    Route::post('/noticias/registrar', 'store')->name('registrar_noticias');
    Route::post('/noticias/actualizar/{id}', 'update')->name('actualizar_noticias');
    Route::delete('/noticias/eliminar/{id}', 'destroy')->name('eliminar_noticias');
  });

  Route::controller(ImageController::class)->group(function () {
    Route::get('/imagenes', 'index')->name('listar_imagenes');
    Route::get('/imagenes/ver/{id}', 'show')->name('ver_imagenes');
    Route::get('/imagenes/registrar', 'create')->name('crear_imagenes');
    Route::post('/imagenes/registrar', 'store')->name('registrar_imagenes');
    Route::post('/imagenes/eliminar', 'destroy')->name('eliminar_imagenes');
  });

  Route::controller(MensajeController::class)->group(function () {
    Route::get('/mensajes', 'index')->name('listar_mensajes');
    Route::get('/mensajes/ver/{id}', 'show')->name('ver_mensajes');
    Route::delete('/mensajes/eliminar/{id}', 'destroy')->name('eliminar_mensajes');
  });

  Route::get('datatables/es', function () {
    return response()->file(public_path('datatables/es-ES.json'));
  })->name('datatables_es');

});

Route::post('/mensajes/registrar',[MensajeController::class, 'store'])->name('registrar_mensajes');


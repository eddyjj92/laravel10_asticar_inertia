<?php

namespace App\Http\Middleware;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
      return array_merge(parent::share($request), [
        // Synchronously...
        'appName' => config('app.name'),

        // Lazily...
        'auth.user' => fn () => $request->user()
          ? $this->agregarPermisos($request->user())
          : null,
        'permissions' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : [],
        'flash' => [
          'message' => fn () => $request->session()->get('message')
        ],
        'mensajesSinLeer' => fn () => $this->obtenerMensajes()
      ]);
    }

    private function agregarPermisos ($user){
      $roles = $user->roles;
      foreach ($roles as $role){
        $role->permissions->pluck('name');
      }
      return $user;
    }

    private function obtenerMensajes(){
      $user = Auth::user();
      if(isset($user) && $user->can('ver-mensaje')){
        return Mensaje::where('estado', false)->get();
      }
      return [];
    }
}

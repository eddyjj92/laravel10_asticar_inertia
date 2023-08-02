<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{

  public function login(){
    if(Auth::user()) {
      return redirect()->intended('dashboard');
    }
    return Inertia::render('Login', [
      'configs' => Config::all()
    ]);
  }

  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function authenticate(Request $request)
  {
    $credentials = ['email' => $request->email, 'password' => $request->password, 'habilitado' => true];
    try {
      if (Auth::attempt($credentials,$request->remember)) {
        // Authentication passed...
        return redirect()->intended('dashboard');
      }else{
        return back()->withErrors(['credenciales' => 'Credenciales Inválidas']);
      }
    }catch (\Exception $exception){
      return back()->withErrors(['credenciales' => $exception->getMessage()]);
    }
  }

  public function logout(){
    Auth::logout();
    return redirect()->route('home');
  }
}

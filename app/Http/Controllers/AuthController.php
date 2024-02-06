<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     /**
	* Función que muestra la vista de logados o la vista con el formulario de Login
	*/
	public function index()
	{

	    // Comprobamos si el usuario ya está logado
	    if (Auth::check()) {

	        // Si está logado le mostramos la vista de logados
	        return view('home');
	    }

	    // Si no está logado le mostramos la vista con el formulario de login
	    return view('auth.login');
	}

    /**
	* Función que se encarga de recibir los datos del formulario de login, comprobar que el usuario existe y
	* en caso correcto logar al usuario
	*/
	public function login(Request $request)
	{
	    // Comprobamos que el email y la contraseña han sido introducidos
	    $request->validate([
	        'username' => 'required',
	        'password' => 'required',
	    ]);

	    // Almacenamos las credenciales de username y contraseña
	    $credentials = $request->only('username', 'password');

	    // Si el usuario existe lo logamos y lo llevamos a la vista de "logados" con un mensaje
	    if (Auth::attempt($credentials)) {
	        return redirect()->intended('/')
	            ->withSuccess('Logado Correctamente');
	    }

	    // Si el usuario no existe devolvemos al usuario al formulario de login con un mensaje de error
	    return redirect("/")->withSuccess('Los datos introducidos no son correctos');
	}

	/**
	* Función que muestra la vista de logados si el usuario está logado y si no le devuelve al formulario de login
	* con un mensaje de error
	*/
	public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

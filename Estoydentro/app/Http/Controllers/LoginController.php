<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Clases para mostrar la imagen
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Usuario;
use App\Models\Jugador;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class LoginController extends Controller
{


    function index(){
        // return view('auth.login');
        return view('app.login');
    }

    // Método para redirigir al usuario dependiendo del Rol
    function redirectPath(){
        // Este método sirve para indicarle al sistema
        // Cuál es la página de inicio dependiendo de su rol
        // Con esta línea RECUPERO AL USUARIO QUE INICIÓ SESIÓN
        // $this->guard()->user()

     // Obtén al usuario autenticado directamente con Auth::user()
     $user = Auth::user();

     switch($user->idrol){
         case 2:
             return 'home/jugador';
         default:
             return 'home/administrador';
     }
    }

    function login(Request $r){
        $datos = $r->all();
        // Aquí se realiza el login
        // LOGIN MANUAL
        if(Auth::attempt(["email" => $datos['email'], "password" => $datos['password']]))
        {

            $user = Auth::user(); // Obtener al usuario autenticado

            // Esta es la línea que he modificado:
            return $this->authenticated($r, $user) 
                ?: redirect()->intended($this->redirectPath()); 
            // En esta línea de código ya se inició sesión
            // Redirigir al usuario dependiendo del rol
            //return $this->authenticated($r, $this->guard()->user())
                //?: redirect()->intended($this->redirectPath());
        } else {
            //dd('Datos incorrectos');
            return view('app.500');
        }
    }

    protected function authenticated(Request $request, $user){
        // Aquí puedes agregar lógica adicional tras el login
        // Por ejemplo, redirigir dependiendo del rol
        return null; // O deja vacío si no necesitas hacer nada adicional
    }
    function cerrar_sesion(){
        // Borro todos los datos de la sesión
        Session::flush();
        // Redirijo al login
        return redirect()->route('login');
    }
}

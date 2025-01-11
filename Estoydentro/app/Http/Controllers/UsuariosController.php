<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Usuario;
use App\Models\Jugador;
use App\Models\Rol; // Modelo de Propiedad
//use App\Models\Jugador; 
//use App\Models\Partida; 

class UsuariosController extends Controller
{
    function listado(){
        $datos=array();
        //Este metodo del modelo obtiene todos los datos de la tabla //Propiedad
        $datos['usuarios']=Usuario::join('rol','rol.id','=','usuario.idrol')
        
        ->select(
            "usuario.email"
            ,"usuario.id"
            ,"usuario.idrol"
            ,"rol.nombre"
        )
        
                         
        
              
        ->get();
        //usuario.listado significa que hay una carpeta
        //llamada usuario y ahi hay un archivo que se llama
        //listado
        return view('usuarios.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            //Agregar
            $datos['operacion']='Agregar';
            $usuario=new Usuario();
            $usuario->id=0;
        } else {
            //Modificar
            $datos['operacion']='Modificar';
            //El metodo find sirve para recuperar informacion
            //del modelo por medio del id
            $usuario=Usuario::find($id);
        }
        $datos['usuario']=$usuario;

         // Obtener todas las opciones de tipos de usuario y regiones
        $datos['roles'] = Rol::all();
         //$datos['jugadores'] = Jugador::all();
         //$datos['partidas'] = Partida::all();
        return view('usuarios.formulario')->with($datos);
    }
    
    function operaciones(Request $r){
        $datos=$r->all();
        //leo el archivo que subio el usuario
        
        switch ($datos['operacion']) {
            case 'Agregar':
                //Insertar el registro en la bd
                $j=new Usuario();
                $j->email=$datos['email'];
                if($datos['password']!=''){
                    $j->password=bcrypt($datos['password']);

                }
                $j->idrol=$datos['idrol'];
                $j->save();

                
                break;

            case 'Modificar':
                //Recupero al modelo para editarlo y saber si tiene una foto
                //asociada
                $j=Usuario::find($datos['id']);
               
                $j->email=$datos['email'];
                if($datos['password']!=''){
                    $j->password=bcrypt($datos['password']);

                }
                $j->idrol=$datos['idrol'];
               

            
                $j->save();
                break;

            case 'Eliminar':
                //Recupero la informacion de la bd
                $j=Usuario::find($datos['id']);

                
                $j->delete();
                break;
        }
        return redirect()->route('index_usuarios');
    }
function home(){
    //dd('HOLA DIOOOOOS!;');
    // 1. Recupero al usuario que inició sesión
    $usuario = Auth::user();
        
    // 2. Obtengo al jugador relacionado al usuario
    $jugador = Jugador::where('idusuario', $usuario->id)->first();
    if($jugador)
    $nombre = $jugador->nombre;
    else
    $nombre='';
    
    // Recuperar de la sesión al USUARIO
    $datos = array();
    $datos['nombre'] = $nombre;
    //dd('Hola!!!!!'.$nombre );
    return view('home.administrador')->with($datos);
}
 
}
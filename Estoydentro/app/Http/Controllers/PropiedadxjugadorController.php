<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Propiedadxjugador;
use App\Models\Propiedad; 
use App\Models\Jugador; 
use App\Models\Partida; 

class PropiedadxjugadorController extends Controller
{
    function listado(){
        $datos=array();
        //Este metodo del modelo obtiene todos los datos de la tabla //Propiedad
        //$datos['propiedadesxjugadores']=Propiedadxjugador::all();
        $datos['propiedadesxjugadores'] = Propiedadxjugador::join('jugador', 'propiedadxjugador.idjugador', '=', 'jugador.id')
    ->join('propiedad', 'propiedadxjugador.idpropiedad', '=', 'propiedad.id')
    ->join('partida', 'propiedadxjugador.idpartida', '=', 'partida.id')
    ->select(
        'propiedadxjugador.id',
        'jugador.nombre AS idjugador',
        'propiedad.nombre AS idpropiedad',
        'partida.clave AS idpartida'
    )
    ->get();
        //propiedadxjugador.listado significa que hay una carpeta
        //llamada propiedadxjugador y ahi hay un archivo que se llama
        //listado
        return view('propiedadxjugador.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            //Agregar
            $datos['operacion']='Agregar';
            $propiedadxjugador=new Propiedadxjugador();
            $propiedadxjugador->id=0;
        } else {
            //Modificar
            $datos['operacion']='Modificar';
            //El metodo find sirve para recuperar informacion
            //del modelo por medio del id
            $propiedadxjugador=Propiedadxjugador::find($id);
        }
        $datos['propiedadxjugador']=$propiedadxjugador;

         // Obtener todas las opciones de tipos de propiedadxjugador y regiones
         $datos['propiedades'] = Propiedad::all();
         $datos['jugadores'] = Jugador::all();
         $datos['partidas'] = Partida::all();
        return view('propiedadxjugador.formulario')->with($datos);
    }
    
    function operaciones(Request $r){
        $datos=$r->all();
        //leo el archivo que subio el usuario
        $archivo=$r->file('foto');
        switch ($datos['operacion']) {
            case 'Agregar':
                //Insertar el registro en la bd
                $j=new Propiedadxjugador();
                $j->idpropiedad=$datos['idpropiedad'];
                $j->idjugador=$datos['idjugador'];
                $j->idpartida=$datos['idpartida'];
                $j->save();

                
                break;

            case 'Modificar':
                //Recupero al modelo para editarlo y saber si tiene una foto
                //asociada
                $j=Propiedadxjugador::find($datos['id']);
               
                $j->idpropiedad=$datos['idpropiedad'];
                $j->idjugador=$datos['idjugador'];
                $j->idpartida=$datos['idpartida'];
               

            
                $j->save();
                break;

            case 'Eliminar':
                //Recupero la informacion de la bd
                $j=Propiedadxjugador::find($datos['id']);

                
                $j->delete();
                break;
        }
        return redirect()->route('index_propiedadxjugador');
    }

 
}
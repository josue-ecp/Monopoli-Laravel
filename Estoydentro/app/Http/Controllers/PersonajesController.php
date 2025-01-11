<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Personajes;
use Illuminate\Support\Facades\Auth;

class PersonajesController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Personajes::all();
        return view('personajes.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            $datos['personajes']=new Personajes();
            $datos['operation']='Agregar';
        }
        else{
            $datos['personajes']=Personajes::find($id);
            $datos['operation']='Modificar'; 
        }
        return view('personajes.formulario')->with($datos);

    }

    function save(Request $r){
        $context=$r->all();
        switch($context['operation']){
            case 'Agregar':
                $personajes=new Personajes();
                $personajes->nombre=$context['nombre'];
                $personajes->save();
            break;
            case 'Modificar':
                $personajes=Personajes::find($context['id']);
                $personajes->nombre=$context['nombre'];
                $personajes->save();
            break;
            case 'Eliminar':
                $personajes=Personajes::find($context['id']);
                $personajes->delete();
            break;
        }
        return redirect()->route('index_personajes');
    }
}
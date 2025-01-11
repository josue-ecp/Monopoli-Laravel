<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Plataformas;
use Illuminate\Support\Facades\Auth;

class PlataformasController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Plataformas::all();
        return view('plataformas.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            $datos['plataformas']=new Plataformas();
            $datos['operation']='Agregar';
        }
        else{
            $datos['plataformas']=Plataformas::find($id);
            $datos['operation']='Modificar'; 
        }
        return view('plataformas.formulario')->with($datos);

    }

    function save(Request $r){
        $context=$r->all();
        switch($context['operation']){
            case 'Agregar':
                $plataformas=new Plataformas();
                $plataformas->nombre=$context['nombre'];
                $plataformas->save();
            break;
            case 'Modificar':
                $plataformas=Plataformas::find($context['id']);
                $plataformas->nombre=$context['nombre'];
                $plataformas->save();
            break;
            case 'Eliminar':
                $plataformas=Plataformas::find($context['id']);
                $plataformas->delete();
            break;
        }
        return redirect()->route('index_plataformas');
    }
}
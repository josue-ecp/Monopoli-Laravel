<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Rol::all();
        return view('rol.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            $datos['rol']=new Rol();
            $datos['operation']='Agregar';
        }
        else{
            $datos['rol']=Rol::find($id);
            $datos['operation']='Modificar'; 
        }
        return view('rol.formulario')->with($datos);

    }

    function save(Request $r){
        $context=$r->all();
        switch($context['operation']){
            case 'Agregar':
                $rol=new Rol();
                $rol->nombre=$context['nombre'];
                $rol->save();
            break;
            case 'Modificar':
                $rol=Rol::find($context['id']);
                $rol->nombre=$context['nombre'];
                $rol->save();
            break;
            case 'Eliminar':
                $rol=Rol::find($context['id']);
                $rol->delete();
            break;
        }
        return redirect()->route('index_rol');
    }
}
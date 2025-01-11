<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Bug;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class BugsController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Bug::all();
        return view('bugs.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['bug'] = new Bug();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['bug'] = Bug::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('bugs.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $bug = new Bug();
                $bug->nombre = $context['nombre'];
                $bug->save();
                break;
            case 'Modificar':
                $bug = Bug::find($context['id']);
                $bug->nombre = $context['nombre'];
                $bug->save();
                break;
            case 'Eliminar':
                $bug = Bug::find($context['id']);
                $bug->delete();
                break;
        }
        return redirect()->route('index_bugs');
    }
}

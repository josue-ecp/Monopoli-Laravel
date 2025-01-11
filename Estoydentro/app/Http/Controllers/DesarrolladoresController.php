<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Desarrolladores;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class DesarrolladoresController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Desarrolladores::all();
        return view('desarrolladores.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['desarrollador'] = new Desarrolladores();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['desarrollador'] = Desarrolladores::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('desarrolladores.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $desarrollador = new Desarrolladores();
                $desarrollador->nombre = $context['nombre'];
                $desarrollador->asignacion = $context['asignacion'];
                $desarrollador->save();
                break;
            case 'Modificar':
                $desarrollador = Desarrolladores::find($context['id']);
                $desarrollador->nombre = $context['nombre'];
                $desarrollador->asignacion = $context['asignacion'];
                $desarrollador->save();
                break;
            case 'Eliminar':
                $desarrollador = Desarrolladores::find($context['id']);
                $desarrollador->delete();
                break;
        }
        return redirect()->route('index_desarrolladores');
    }
}
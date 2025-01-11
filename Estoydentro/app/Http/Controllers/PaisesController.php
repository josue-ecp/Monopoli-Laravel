<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Paises;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class PaisesController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Paises::all();
        return view('paises.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['pais'] = new Paises();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['pais'] = Paises::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('paises.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $pais = new Paises();
                $pais->nombre = $context['nombre'];
                $pais->continente = $context['continente'];
                $pais->save();
                break;
            case 'Modificar':
                $pais = Paises::find($context['id']);
                $pais->nombre = $context['nombre'];
                $pais->continente = $context['continente'];
                $pais->save();
                break;
            case 'Eliminar':
                $pais = Paises::find($context['id']);
                $pais->delete();
                break;
        }
        return redirect()->route('index_paises');
    }
}
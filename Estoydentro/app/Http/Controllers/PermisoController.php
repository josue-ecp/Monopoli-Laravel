<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Permiso;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class PermisoController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Permiso::all();
        return view('permiso.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['permiso'] = new Permiso();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['permiso'] = Permiso::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('permiso.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $permiso = new Permiso();
                $permiso->nombre = $context['nombre'];
                $permiso->clave = $context['clave'];
                $permiso->save();
                break;
            case 'Modificar':
                $permiso = Permiso::find($context['id']);
                $permiso->nombre = $context['nombre'];
                $permiso->clave = $context['clave'];
                $permiso->save();
                break;
            case 'Eliminar':
                $permiso = Permiso::find($context['id']);
                $permiso->delete();
                break;
        }
        return redirect()->route('index_permiso');
    }
}
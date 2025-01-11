<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Proveedores;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Proveedores::all();
        return view('proveedores.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['proveedor'] = new Proveedores();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['proveedor'] = Proveedores::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('proveedores.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $proveedor = new Proveedores();
                $proveedor->nombre = $context['nombre'];
                $proveedor->save();
                break;
            case 'Modificar':
                $proveedor = Proveedores::find($context['id']);
                $proveedor->nombre = $context['nombre'];
                $proveedor->save();
                break;
            case 'Eliminar':
                $proveedor = Proveedores::find($context['id']);
                $proveedor->delete();
                break;
        }
        return redirect()->route('index_proveedores');
    }
}
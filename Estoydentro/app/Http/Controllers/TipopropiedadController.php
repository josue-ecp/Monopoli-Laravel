<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Tipopropiedad;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class TipopropiedadController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Tipopropiedad::all();
        return view('tipopropiedad.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['tipopropiedad'] = new Tipopropiedad();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['tipopropiedad'] = Tipopropiedad::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('tipopropiedad.formulario')->with($datos);
    }

    function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $tipopropiedad = new Tipopropiedad();
                $tipopropiedad->nombre = $context['nombre'];
                $tipopropiedad->save();
                break;
            case 'Modificar':
                $tipopropiedad = Tipopropiedad::find($context['id']);
                $tipopropiedad->nombre = $context['nombre'];
                $tipopropiedad->save();
                break;
            case 'Eliminar':
                $tipopropiedad = Tipopropiedad::find($context['id']);
                $tipopropiedad->delete();
                break;
        }
        return redirect()->route('index_tipopropiedad');
    }
}
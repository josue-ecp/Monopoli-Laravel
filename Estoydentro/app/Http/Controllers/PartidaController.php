<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\BusinessLogic\BoPartida;
use App\BusinessLogic\BoTurno;
use Illuminate\Support\Facades\DB;
use App\BusinessLogic\BoControl;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Partida;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class PartidaController extends Controller
{
    function index(){
        // Listar todos los registros de los alumnos
        $datos = array();
        $datos['registros'] = Partida::all();
        return view('partida.listado')->with($datos);
    }

   /* function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['partida'] = new Partida();
            $datos['operacion'] = 'Agregar';
        } else {
            // Editar
            $datos['partida'] = Partida::find($id);
            $datos['operacion'] = 'Modificar';
        }

        return view('partida.formulario')->with($datos);
    }*/

    function formulario(){
        return view('partida.formulario');
    }

   /* function save(Request $r){
        // 1.-Recupero toda la información de la petición
        $context = $r->all();
        switch($context['operacion']){
            case 'Agregar':
                $partida = new Partida();
                $partida->clave = $context['clave'];
                $partida->fecha = $context['fecha'];
                $partida->save();
                break;
            case 'Modificar':
                $partida = Partida::find($context['id']);
                $partida->clave = $context['clave'];
                $partida->fecha = $context['fecha'];
                $partida->save();
                break;
            case 'Eliminar':
                $partida = Partida::find($context['id']);
                $partida->delete();
                break;
        }
        return redirect()->route('index_partida');
    }*/




    public function save(Request $r) {
        $context = $r->all();
        $bo = new BoPartida();
        $objeto = new \StdClass();
        $objeto->clave = $context['clave'];
        $objeto->nombre = $context['nombre'];
        $jugador = dame_jugador(); // Assuming this function fetches the current player
        $objeto->idjugador = $jugador->id;
        $resultado = $bo->crear($objeto);

       if ($resultado->status!='OK') {
            return view('partida.clave_existente');
        }
        return view('partida.creada');
    }

    public function formulario_unir() {
        return view('partida.formulario_unir');
    }

    public function unir(Request $r) {
        $context = $r->all();
        $bo = new BoPartida();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->clave = $context['clave'];
        $resultado = $bo->unir($objeto);

        if ($resultado->status == 'OK') {
            //dd('Bienvenido a la partida');
            return view('partida.entro');
        } else {
            //dd($resultado->mensaje);
            return view('partida.clave_noexiste', ['mensaje' => $resultado->mensaje]);
        }
    }

    public function iniciar(Request $r) {
        $context = $r->all();
        $objeto = new \StdClass();
        $objeto->idpartida = $context['idpartida'];
        $bo = new BoPartida();
        $bo->iniciar($objeto);
        return view('partida.inicio');
    }

    public function continuar(Request $r) {
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $bo = new BoPartida();
        $res = $bo->validar_turno($objeto);
        $datos = array();

        if ($res->status == 'OK') {
            // Si es tu turno
            $datos['idpartida'] = $objeto->idpartida;
            $datos['idjugador'] = $objeto->idjugador;
            return view('partida.iniciar_turno')->with($datos);
        } else {
            // No es tu turno
            return view('partida.turno_invalido')->with($datos);
        }
    }


    function jugar_turno(Request $r){
        $context=$r->all();
        $objeto=new \StdClass();
        $jugador=dame_jugador();
        $objeto->idjugador=$jugador->id;
        $objeto->idpartida=$context['idpartida'];
        $boturno=new BoTurno();
        $res=$boturno->jugar($objeto);
        $datos=array();
        

        //nuevo

        $estatusJugador = \DB::table('partidaxjugador')
        ->where('idjugador', $jugador->id)
        ->where('idpartida', $context['idpartida'])
        ->value('status'); // Obtiene el valor de la columna 'estatus'

    if ($estatusJugador === 0) {
        // Redirigir a una vista que indique que el jugador ha perdido
        $datos['mensaje'] = "El jugador ha sido eliminado de la partida.";
        $datos['idpartida'] = $context['idpartida'];
        return view('turno.perdio')->with($datos);
    }

    //dd($res);
        //nuevo

        
        switch($res->tipo){
            case 'PROPIEDAD':
                if($res->idjugador==0){
                    $datos['casilla']=$res;
                    $datos['idpartida']=$context['idpartida'];
                    return view('turno.propiedad_disponible')->with($datos);
                
                }
                else{
                    $datos['casilla']=$res;
                    $datos['idpartida']=$context['idpartida'];
                    return view('turno.propiedad_ocupada')->with($datos);
                }
            break;
            case 'SALIDA':
                return view('turno.salida')->with($datos);
            break;
            case 'OCEANIA':
                return view('turno.oceania')->with($datos);
            break;
            case 'LINEA AEREA':
                if ($res->idjugador == 0) {
                    // Casilla de línea aérea disponible
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.linea_aerea_disponible')->with($datos);
                } else {
                    // Casilla de línea aérea ocupada
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.linea_aerea_ocupada')->with($datos);
                }
                break;
    
            break;
            case 'GROELANDIA':
                return view('turno.groelandia')->with($datos);
            break;
            case 'VISA':
                $datos['casilla']=$res;
                return view('turno.visa')->with($datos);
            break;
            case 'ADUANA':
                $datos['casilla']=$res;
                return view('turno.aduana')->with($datos);
            break;
            case 'DEPORTADO':
                $datos['casilla']=$res;
                return view('turno.deportado')->with($datos);
            break;
            case 'CARTA':
                $datos['casilla']=$res;
                return view('turno.carta')->with($datos);
            break;
            case 'TELEGRAMA':
                $datos['casilla']=$res;
                return view('turno.telegrama')->with($datos);
            break;
            
            case 'CONSULADO':
                if ($res->idjugador == 0) {
                    // Casilla de línea aérea disponible
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.consulado_disponible')->with($datos);
                } else {
                    // Casilla de línea aérea ocupada
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.consulado_ocupado')->with($datos);
                }
            break;

            case 'EMBAJADA':
                if ($res->idjugador == 0) {
                    // Casilla de línea aérea disponible
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.embajada_disponible')->with($datos);
                } else {
                    // Casilla de línea aérea ocupada
                    $datos['casilla'] = $res;
                    $datos['idpartida'] = $context['idpartida'];
                    return view('turno.embajada_ocupado')->with($datos);
                }
            break;
            
        }
    }
    

    public function comprar_propiedad(Request $r) {
        $bo = new BoControl();
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $objeto->idpropiedad = $context['idpropiedad'];
        $objeto->dinero = $context['dinero'];
        $res = $bo->comprar_propiedad($objeto);

        if ($res->perdio == 1) {
            dd('Perdiste');
            return view('turno.perdio');
        } else {
            
            return view('turno.propiedad_comprada');
        }
    }


    public function comprar_Linea_Area(Request $r) {
        $bo = new BoControl();
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $objeto->idpropiedad = $context['idpropiedad'];
        $objeto->dinero = $context['dinero'];
        $res = $bo->comprar_Linea_Area($objeto);

        if ($res->perdio == 1) {
            dd('Perdiste');
            return view('turno.perdio');
        } else {
            
            return view('turno.linearea_comprada');
        }
    }


    public function comprar_Embajada(Request $r) {
        $bo = new BoControl();
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $objeto->idpropiedad = $context['idpropiedad'];
        $objeto->dinero = $context['dinero'];
        $res = $bo->comprar_Embajada($objeto);

        if ($res->perdio == 1) {
            dd('Perdiste');
            return view('turno.perdio');
        } else {
            
            return view('turno.linearea_comprada');
        }
    }


    public function comprar_Consulado(Request $r) {
        $bo = new BoControl();
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $objeto->idpropiedad = $context['idpropiedad'];
        $objeto->dinero = $context['dinero'];
        $res = $bo->comprar_Consulado($objeto);

        if ($res->perdio == 1) {
            dd('Perdiste');
            return view('turno.perdio');
        } else {
            
            return view('turno.consulado_comprado');
        }
    }

    public function pagar_renta(Request $r) {
        $context = $r->all();
        $objeto = new \StdClass();
        $jugador = dame_jugador();
        $objeto->idjugador = $jugador->id;
        $objeto->idpartida = $context['idpartida'];
        $objeto->idpropiedad = $context['idpropiedad'];
        $objeto->dinero = $context['dinero'];

        $bo = new BoControl();
        $bo->pagar_renta($objeto);

        //dd('Ya pagaste renta');
        return view('turno.renta');
    }





    public function gestionarPropiedades(Request $request)
    {
        $idpartida = $request->idpartida;
        $idjugador = $request->idjugador;
    
        // Obtener propiedades del jugador con información adicional de la región
        $propiedades = DB::table('partidaxjugador')
            ->join('propiedadxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
            ->join('propiedad', 'propiedad.id', '=', 'propiedadxjugador.idpropiedad')
            ->join('region', 'region.id', '=', 'propiedad.idregion') // Join con la tabla región
            ->where('partidaxjugador.idpartida', $idpartida)
            ->where('partidaxjugador.idjugador', $idjugador)
            ->select(
                'propiedad.id as id_propiedad',
                'propiedad.nombre as nombre_propiedad',
                'propiedadxjugador.restaurantes',
                'propiedadxjugador.hotel',
                'region.nombre as nombre_region', // Nombre de la región
                'region.color as color'          // Color de la región
            )
            ->get();
    
        return view('turno.compra_ryh', [
            'idpartida' => $idpartida,
            'idjugador' => $idjugador,
            'propiedades' => $propiedades
        ]);
    }
    

protected $boControl;

    public function __construct(BoControl $boControl)
    {
        $this->boControl = $boControl;
    }


    
    public function comprarRestauranteHotel(Request $r)
    {
        $objeto = new \StdClass();
        $objeto->idjugador = $r->idjugador;
        $objeto->idpartida = $r->idpartida;
        $objeto->id_propiedad = $r->id_propiedad;
        $objeto->tipo_compra = $r->tipo_compra;  // 'restaurante' o 'hotel'

        // Llamar a la función que maneja la compra
        $resultado = $this->comprar_restaurante_hotel($objeto);

        // Manejar la respuesta y redirigir según el resultado
        if ($resultado->exito) {
            //return redirect()->route('partida.detalle', ['idpartida' => $r->idpartida])->with('success', $resultado->mensaje);
            return view('partida.detalle');
        } else {
            //return redirect()->back()->with('error', $resultado->mensaje);
            return view('partida.comerr');
        }
    }

    public function comprar_restaurante_hotel($objeto)
{
    $resultado = new \StdClass();

    // Verificar si el jugador está relacionado con la partida correctamente
    $id_partidaxjugador = DB::table('partidaxjugador')
        ->where('idjugador', $objeto->idjugador)
        ->where('idpartida', $objeto->idpartida)
        ->value('id');

    if (!$id_partidaxjugador) {
        $resultado->mensaje = "Relación entre el jugador y la partida no encontrada.";
        $resultado->exito = false;
        return $resultado;
    }

    // Verificar la propiedad del jugador
    $propiedad_jugador = DB::table('propiedadxjugador')
        ->where('idpropiedad', $objeto->id_propiedad)
        ->where('idpartidaxjugador', $id_partidaxjugador)
        ->first();

    if (!$propiedad_jugador) {
        $resultado->mensaje = "No posees esta propiedad.";
        $resultado->exito = false;
        return $resultado;
    }

    // Obtener información de la propiedad
    $propiedad = DB::table('propiedad')
        ->where('id', $objeto->id_propiedad)
        ->select('r1', 'r2', 'r3', 'hotel as precio_hotel', 'nombre')
        ->first();

    if (!$propiedad) {
        $resultado->mensaje = "Propiedad no encontrada.";
        $resultado->exito = false;
        return $resultado;
    }

    // Lógica para comprar restaurante
    if ($objeto->tipo_compra == 'restaurante') {
        $restaurantes_actuales = $propiedad_jugador->restaurantes;

        if ($restaurantes_actuales >= 3) {
            $resultado->mensaje = "Ya tienes el máximo número de restaurantes.";
            $resultado->exito = false;
            return $resultado;
        }

        // Calcular el precio del siguiente restaurante
        $precio = match ($restaurantes_actuales) {
            0 => $propiedad->r1,
            1 => $propiedad->r2,
            2 => $propiedad->r3,
            default => null,
        };

        if (is_null($precio)) {
            $resultado->mensaje = "Error al calcular el precio del restaurante.";
            $resultado->exito = false;
            return $resultado;
        }

        // Incrementar el número de restaurantes en la propiedad
        DB::table('propiedadxjugador')
            ->where('idpropiedad', $objeto->id_propiedad)
            ->where('idpartidaxjugador', $id_partidaxjugador)
            ->increment('restaurantes');
    }

    // Lógica para comprar hotel
    if ($objeto->tipo_compra == 'hotel') {
        if ($propiedad_jugador->hotel) {
            $resultado->mensaje = "Ya tienes un hotel en esta propiedad.";
            $resultado->exito = false;
            return $resultado;
        }

        // Asignar el precio del hotel
        $precio = $propiedad->precio_hotel;

        // Actualizar el hotel
        DB::table('propiedadxjugador')
            ->where('idpropiedad', $objeto->id_propiedad)
            ->where('idpartidaxjugador', $id_partidaxjugador)
            ->update(['hotel' => 1]);
    }

    // Actualizar dinero
    $modifica_dinero_obj = new \StdClass();
    $modifica_dinero_obj->idjugador = $objeto->idjugador;
    $modifica_dinero_obj->idpartida = $objeto->idpartida;
    $modifica_dinero_obj->dinero = -$precio;

    $boControl = new \App\BusinessLogic\BoControl();
    $dinero_resultado = $boControl->modifica_dinero($modifica_dinero_obj);

    if ($dinero_resultado->perdio) {
        $resultado->mensaje = "Has perdido el juego por falta de dinero.";
        $resultado->exito = false;
        return $resultado;
    }

    $resultado->mensaje = ucfirst($objeto->tipo_compra) . " comprado exitosamente.";
    $resultado->exito = true;

    return $resultado;
}


public function verificarRegionYComprarHotel(Request $request)
{
    $objeto = new \StdClass();
    $objeto->idjugador = $request->idjugador;
    $objeto->idpartida = $request->idpartida;
    $objeto->id_propiedad = $request->id_propiedad;

    $resultado = new \StdClass();

    // Obtener la propiedad y su región
    $propiedad = DB::table('propiedad')
        ->join('region', 'propiedad.idregion', '=', 'region.id') // Relacionar con la tabla región
        ->where('propiedad.id', $objeto->id_propiedad)
        ->select('propiedad.idregion', 'region.nombre as nombre_region', 'region.color', 'propiedad.nombre', 'propiedad.hotel as precio_hotel')
        ->first();

    if (!$propiedad) {
        $resultado->mensaje = "Propiedad no encontrada.";
        $resultado->exito = false;
        return redirect()->back()->with('error', $resultado->mensaje);
    }

    // Obtener todas las propiedades de la misma región
    $propiedades_region = DB::table('propiedad')
        ->where('idregion', $propiedad->idregion)
        ->pluck('id'); // Extraemos solo los IDs de las propiedades

    // Verificar si el jugador posee todas las propiedades de la región
    $id_partidaxjugador = DB::table('partidaxjugador')
        ->where('idjugador', $objeto->idjugador)
        ->where('idpartida', $objeto->idpartida)
        ->value('id');

    $propiedades_jugador = DB::table('propiedadxjugador')
        ->whereIn('idpropiedad', $propiedades_region)
        ->where('idpartidaxjugador', $id_partidaxjugador)
        ->pluck('idpropiedad');

    // Comparar si el jugador tiene todas las propiedades de la región
    if ($propiedades_jugador->count() < $propiedades_region->count()) {
        $resultado->mensaje = "No posees todas las propiedades de la región " . $propiedad->nombre_region . " para comprar un hotel.";
        $resultado->exito = false;
        return redirect()->back()->with('error', $resultado->mensaje);
    }

    // Verificar si ya tiene hotel en esta propiedad
    $propiedad_jugador = DB::table('propiedadxjugador')
        ->where('idpropiedad', $objeto->id_propiedad)
        ->where('idpartidaxjugador', $id_partidaxjugador)
        ->first();
        //dd($propiedad_jugador); 
    if (!$propiedad_jugador || $propiedad_jugador->hotel) {
        $resultado->mensaje = "Ya tienes un hotel en esta propiedad o no posees la propiedad.";
        $resultado->exito = false;
        return redirect()->back()->with('error', $resultado->mensaje);
    }

    // Asignar el precio del hotel
    $precio_hotel = $propiedad->precio_hotel;

    // Actualizar la propiedad con el hotel
    DB::table('propiedadxjugador')
        ->where('idpropiedad', $objeto->id_propiedad)
        ->update(['hotel' => 1]);

    // Actualizar el dinero del jugador
    $modifica_dinero_obj = new \StdClass();
    $modifica_dinero_obj->idjugador = $objeto->idjugador;
    $modifica_dinero_obj->idpartida = $objeto->idpartida;
    $modifica_dinero_obj->dinero = -$precio_hotel;

    // Usamos la instancia de BoControl para llamar a modifica_dinero
    $boControl = new \App\BusinessLogic\BoControl();
    $dinero_resultado = $boControl->modifica_dinero($modifica_dinero_obj);

    if ($dinero_resultado->perdio) {
        $resultado->mensaje = "Has perdido el juego por falta de dinero.";
        $resultado->exito = false;
        return redirect()->back()->with('error', $resultado->mensaje);
    }

    $resultado->mensaje = "Hotel comprado exitosamente en la región " . $propiedad->nombre_region . " (color: " . $propiedad->color . ").";
    $resultado->exito = true;

    return view('partida.detalle');
}

    


}



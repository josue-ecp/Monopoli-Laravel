<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuscadorController extends Controller
{
    function index(Request $r){
        $context = $r->all();

        if(isset($context['criterio'])){
            $criterio = $context['criterio'];
            
            $consulta = DB::table('tipopropiedad')
                ->join('propiedad', 'propiedad.idtipopropiedad', '=', 'tipopropiedad.id')
                ->join('region', 'propiedad.idregion', '=', 'region.id')
                ->join('propiedadxjugador', 'propiedad.id', '=', 'propiedadxjugador.idpropiedad')
                ->join('partida', 'partida.id', '=', 'propiedadxjugador.idpartida')
                ->join('jugador', 'jugador.id', '=', 'propiedadxjugador.idjugador')
                ->whereRaw("tipopropiedad.nombre like '%".$criterio."%' 
                    or region.nombre like '%".$criterio."%' 
                    or jugador.nombre like '%".$criterio."%' 
                    or partida.clave like '%".$criterio."%'")
                ->select(
                    'tipopropiedad.nombre as tipo_propiedad',
                    'region.nombre as region',
                    'propiedad.precio',
                    'partida.clave',
                    'jugador.nombre as jugador'
                    
                );
            
            // Ejecutar consulta
            $registros = $consulta->get();
        } else {
            $criterio = '';
            $registros = array();
        }

        $datos = array();
        $datos['registros'] = $registros;
        $datos['criterio'] = $criterio;

        return view('buscador.index')->with($datos);
    }
}
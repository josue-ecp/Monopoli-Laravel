<?php

namespace App\BusinessLogic;
use Illuminate\Support\Facades\DB;
use App\Models\Partida;
use App\Models\Tablero;

use App\Models\Jugadores;
use App\Models\Propiedad;
use App\Models\Carta;
use App\Models\Telegrama;
use App\Models\Propiedadxjugador;
use App\Models\Partidaxjugador;


use App\BusinessLogic\BoTurno;

class BoControl
{
    // id 
    // idjugador dueño de la propiedad
    // idpropiedad

    function obtener_precio($objeto) {
        $resultado = new \stdClass();
        $resultado->precio = 0;
        // Recuperar la información de pertenencia
        $pertenece = DB::table('propiedadxjugador')
        ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
        ->where('partidaxjugador.idpartida', $objeto->idpartida)
        ->where('propiedadxjugador.idpropiedad', $objeto->idpropiedad)
        ->where('tipo', 'PROPIEDAD')
        ->where('partidaxjugador.idjugador', $objeto->idjugador)
        ->select(
            'propiedadxjugador.tipo',
            'propiedadxjugador.status',
            'propiedadxjugador.restaurantes',
            'propiedadxjugador.hotel'
        )
        
            ->first();

            $propiedad=Propiedad::find($objeto->idpropiedad);

        // Si es hotel entonces es el precio del hotel
        if ($pertenece->hotel==1) {
            $resultado->precio = $propiedad->hotel;
        } else {
            // 2.2.1 NO
            // 2.2.1.1 Si tiene restaurantes
            if ($pertenece->restaurantes != 0) {
                // 2.2.1.1.1 Es dependiente del número, le cobro la renta correspondiente
                switch ($pertenece->restaurantes) {
                    case 1:
                        $resultado->precio = $propiedad->r1;
                        break;
                    case 2:
                        $resultado->precio = $propiedad->r2;
                        break;
                    case 3:
                        $resultado->precio = $propiedad->r3;
                        break;
                }
            } else {
                // 2.2.1.2.2 NO
                // 2.2.1.2.2.1 Averiguamos si el jugador tiene las tres propiedades de la misma región
                // 2.2.2.1.1 Si los tiene, entonces el precio es el base
                $propiedades = Propiedad::where('idregion', $propiedad->idregion)
                    ->get();
                // Si value 0 significa que tiene todas y si value 1 es que por lo menos no TIENE una propiedad
                $bandera = 0;
                foreach ($propiedades as $elemento) {
                    $pertenece2 = DB::table('propiedadxjugador')
                    ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                    ->where('partidaxjugador.idpartida', $objeto->idpartida)
                    ->where('propiedadxjugador.idpropiedad', $elemento->id)
                    ->where('tipo', 'PROPIEDAD')
                    ->where('partidaxjugador.idjugador', $objeto->idjugador)
                    ->select(
                        'propiedadxjugador.tipo',
                        'propiedadxjugador.status',
                        'propiedadxjugador.restaurantes',
                        'propiedadxjugador.hotel'
                    )
                    ->first();
                    if (!$pertenece2) {
                        $bandera = 1;
                    }
                }
                if ($bandera == 0) {
                    // Tiene todas las propiedades
                    $resultado->precio = $propiedad->precio * 2;
                } else {
                    // Si por lo menos no tiene 1
                    $resultado->precio = $propiedad->precio;
                }
            }
        }
        return $resultado;
    }




    //nuevo
    function obtener_precio_aerolinea($objeto) {
        $resultado = new \stdClass();
        $resultado->precio = 0;
    
        // Recuperar la propiedad actual
        $propiedad = Propiedad::find($objeto->idpropiedad);
        
        // Verificar si la propiedad existe
        if (!$propiedad) {
            dd('Propiedad no encontrada', $objeto->idpropiedad);
        }
    
        // Recuperar todas las propiedades del jugador de tipo "LINEA AEREA"
        $propiedades_linea_aerea = DB::table('propiedadxjugador')
            ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
            ->join('propiedad', 'propiedad.id', '=', 'propiedadxjugador.idpropiedad')
            ->where('partidaxjugador.idpartida', $objeto->idpartida)
            ->where('partidaxjugador.idjugador', $objeto->idjugador)
            ->where('tipo', 'LINEA AEREA')  // Asegúrate de que el campo tipo está en propiedadxjugador
            ->get();

            //dd($propiedades_linea_aerea);
        
        // Ajustar el precio según el número de propiedades de tipo "LINEA AEREA"
        switch ($propiedades_linea_aerea->count()) {
            case 1:
                $resultado->precio = $propiedad->precio; // Precio base
                break;
            case 2:
                $resultado->precio = $propiedad->precio * 2; // Doble precio
                break;
            case 3:
                $resultado->precio = $propiedad->precio * 3; // Triple precio
                break;
            case 4:
                $resultado->precio = $propiedad->precio * 4; // Cuádruple precio
                break;
            default:
                $resultado->precio = $propiedad->precio; // Precio base
                break;
        }
    
        return $resultado;
    }
    


    function obtener_precio_byc($objeto) {
        $resultado = new \stdClass();
        $resultado->precio = 0;
    
        // Recuperar la propiedad actual
        $propiedad = Propiedad::find($objeto->idpropiedad);
        
        // Verificar si la propiedad existe
        if (!$propiedad) {
            dd('Propiedad no encontrada', $objeto->idpropiedad);
        }
    
        // Recuperar las propiedades de tipo "EMBAJADA" y "CONSULADO" del jugador
        $propiedades = DB::table('propiedadxjugador')
            ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
            ->where('partidaxjugador.idpartida', $objeto->idpartida)
            ->where('partidaxjugador.idjugador', $objeto->idjugador)
            ->whereIn('tipo', ['EMBAJADA', 'CONSULADO']) // Obtener ambos tipos en una consulta
            ->get();
    
        // Verificar si tiene ambas propiedades
        $tiene_embajada = $propiedades->contains('tipo', 'EMBAJADA');
        $tiene_consulado = $propiedades->contains('tipo', 'CONSULADO');
    
        // Calcular el precio
        if ($tiene_embajada && $tiene_consulado) {
            // Multiplicar precio si tiene ambas propiedades
            $resultado->precio = $propiedad->precio * 2;
        } else {
            // Precio normal si no tiene ambas
            $resultado->precio = $propiedad->precio;
        }
    
        return $resultado;
    }
    
    
    

    //nueva

    // El objeto tiene los atributos
    // posición
    // idjugador
    // idpartida

    // Puede caer en:
    // Propiedad (x)
    // Terreno
    // Avanzar
    // Cárcel | Telegrama
    // Oportunidad (x)
    // Decisión (x)
    // Mensaje | Consulado
    // Misión (x)
    // Funciona aquí

    function info_casilla($objeto) {
        $boturno = new BoTurno();
        $resultado = new \stdClass();
        $casilla = Tablero::where('posicion', $objeto->posicion)->first();
        $resultado->tipo = $casilla->tipo;
        //dd($resultado);
        switch ($casilla->tipo) {
            case 'PROPIEDAD':
                /*
                select 
                    partidasxjugador.idpartida,
                    partidasxjugador.idjugador,
                    propiedadxjugador.idpropiedad,
                    propiedadxjugador.tipo,
                    propiedadxjugador.status,
                    propiedadxjugador.restaurantes,
                    propiedadxjugador.hotel
                from propiedadxjugador
                join partidasxjugador on 
                    partidasxjugador.id = propiedadxjugador.idpartidaxjugador
                where partidasxjugador.idpartida = 2
                and propiedadxjugador.idpropiedad = 13
                */
                $propiedad = Propiedad::find($casilla->idorigen);
                $pertenece = DB::table('propiedadxjugador')
                    ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                    ->where('partidaxjugador.idpartida', $objeto->idpartida)
                    ->where('propiedadxjugador.idpropiedad', $propiedad->id)
                    ->select(
                        'partidaxjugador.idpartida',
                        'partidaxjugador.idjugador',
                        'propiedadxjugador.idpropiedad',
                        'propiedadxjugador.tipo',
                        'propiedadxjugador.status',
                        'propiedadxjugador.restaurantes',
                        'propiedadxjugador.hotel'
                    )
                    ->first();
                $resultado->info_propiedad = $propiedad;
                if ($pertenece) {
                    $resultado->info_pertenece = $pertenece;
                    $resultado->idjugador = $pertenece->idjugador;
    
                    if ($pertenece->idjugador == $objeto->idjugador) {
                        $resultado->belong = 1;
                        $boturno->cerrar($objeto);
                    } else {
                        $resultado->belong = 0;
                        $objeto3 = new \stdClass();
                        $objeto3->idpropiedad = $propiedad->id;
                        $objeto3->idjugador = $pertenece->idjugador;
                        $objeto3->idpartida = $objeto->idpartida;
                        $precio_nuevo = $this->obtener_precio($objeto3);
                        $resultado->info_propiedad->precio = $precio_nuevo->precio;
                    }
                } 
                else {
                    $resultado->idjugador = 0;
                }
                
                break;
    
            case 'SALIDA':
                $objeto->dinero = 20000;
                $res = $this->modifica_dinero($objeto);
                $resultado->cerrar($objeto);
                $resultado->mensaje = 'Caíste en la salida';
                break;
    
            case 'VISA':
                $objeto->dinero =- 10000;
                $res = $this->modifica_dinero($objeto);
                $resultado->perdio = $res->perdio;
                $boturno->cerrar($objeto);
                $resultado->mensaje = 'Caíste en visa';
                break;
            
            case 'ADUANA':
                $par = Partidaxjugador::where('idjugador', $objeto->idjugador)
                    ->where('idpartida', $objeto->idpartida)
                    ->first();
                $objeto->dinero = $par->dinero * -.1;
    
                $res = $this->modifica_dinero($objeto);
                $resultado->perdio = $res->perdio;
                $boturno->cerrar($objeto);
                $resultado->mensaje = 'Caíste en aduana';
                break;
            
            case 'OCEANIA':
                $resultado->mensaje = 'Caíste en oceania';
                $boturno->cerrar($objeto);
                break;
    
           /* case 'LINEA AEREA':
                $resultado->mensaje = 'Caíste en linea aerea';
                $boturno->cerrar($objeto);
                break;*/

            case 'GROENLANDIA':
                $resultado->mensaje = 'Caíste en Groenlandia';
                $boturno->cerrar($objeto);
                break;
    
            case 'DEPORTADO':
                $resultado->mensaje = 'Caíste en deportado';
                $objeto->dinero =- 5000;
                $res = $this->modifica_dinero($objeto);
    
                $pxjug = Partidaxjugador::where('idjugador', $objeto->idjugador)
                    ->where('idpartida', $objeto->idpartida)
                    ->first();
                $pxjug->posicion = 31;
                $pxjug->save();
                $resultado->perdio = $res->perdio;
                $boturno->cerrar($objeto);
                break;
    
            case 'CARTA':
                 // $carta=Carta::find(2);
                $carta = Carta::inRandomOrder()->limit(1)->first();
                $resultado->mensaje = $carta->mensaje;
    
                switch ($carta->id) {
                    case 1:
                        $objeto->dinero =50000;
                        $this->modifica_dinero($objeto);
                        break;
    
                    case 2:
                        $par = Partidaxjugador::where('idjugador', $objeto->idjugador)
                            ->where('idpartida', $objeto->idpartida)
                            ->first();
                        $objeto->dinero = ($par->dinero*-1)-1;
                        $res = $this->modifica_dinero($objeto);
                        $resultado->perdio = $res->perdio;
                        break;
    
                    case 3:
                        $par = PartidaxJugador::where('idjugador', '!=', $objeto->idjugador)
                            ->where('idpartida', $objeto->idpartida)
                            ->get();
    
                        foreach ($par as $elemento) {
                            $objeto2 = new \StdClass();
                            $objeto2->idpartida = $objeto->idpartida;
                            $objeto2->idjugador = $elemento->idjugador;
                            $objeto2->dinero = -10000;
                            $this->modifica_dinero($objeto2);
                        }
    
                        $objeto->dinero = count($par) + 10000;
                        $this->modifica_dinero($objeto);
                        break;
                }
                $boturno->cerrar($objeto);
                break;
    
            case 'TELEGRAMA':
                $telegrama = Telegrama::inRandomOrder()->limit(1)->first();
                $resultado->mensaje = $telegrama->mensaje;
                //$telegrama=Telegrama::find(1);
    
                switch ($telegrama->id) {
                    case 1:
                        $propiedad = DB::table('partidaxjugador')
                            ->join('propiedadxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                            ->where('partidaxjugador.idpartida', $objeto->idpartida)
                            ->where('partidaxjugador.idjugador', '!=', $objeto->idjugador)
                            ->select(
                                'propiedadxjugador.id',
                                'partidaxjugador.idjugador',
                                'partidaxjugador.idpartida',
                                'propiedadxjugador.idpropiedad'
                            )
                            ->inRandomOrder()
                            ->limit(1)
                            ->first();
    
                        $par = PartidaxJugador::where('idjugador', $objeto->idjugador)
                            ->where('idpartida', $objeto->idpartida)
                            ->first();
    
                        $proxjug = Propiedadxjugador::find($propiedad->id);
                        $proxjug->idpartidaxjugador = $par->id;
                        $proxjug->save();
                        break;
    
                    case 2:
                        $aumento = rand(1000, 10000);
                        $objeto->dinero = $aumento;
                        $this->modifica_dinero($objeto);
                        break;
    
                    case 3:
                        $par = PartidaxJugador::where('idjugador', $objeto->idjugador)
                            ->where('idpartida', $objeto->idpartida)
                            ->first();
    
                        $turno_nuevo = $par->turno + 1;
                        $jugadores = PartidaxJugador::where('idpartida', $objeto->idpartida)->get();
    
                        if ($turno_nuevo > count($jugadores)) {
                            $turno_nuevo = 1;
                        }
    
                        $jugador_quitar = PartidaxJugador::where('turno', $turno_nuevo)
                            ->where('idpartida', $objeto->idpartida)
                            ->first();
    
                        $objeto2 = new \StdClass();
                        $objeto2->idpartida = $objeto->idpartida;
                        $objeto2->idjugador = $jugador_quitar->idjugador;
                        $objeto2->dinero = -1000;
    
                        $this->modifica_dinero($objeto2);
                        break;
                }
    
                $boturno->cerrar($objeto);
                break;

                case 'LINEA AEREA':
                    
                    /*
                    select 
                        partidasxjugador.idpartida,
                        partidasxjugador.idjugador,
                        propiedadxjugador.idpropiedad,
                        propiedadxjugador.tipo,
                        propiedadxjugador.status,
                        propiedadxjugador.restaurantes,
                        propiedadxjugador.hotel
                    from propiedadxjugador
                    join partidasxjugador on 
                        partidasxjugador.id = propiedadxjugador.idpartidaxjugador
                    where partidasxjugador.idpartida = 2
                    and propiedadxjugador.idpropiedad = 13
                    */
                    $propiedad = Propiedad::find($casilla->idorigen);
                    $pertenece = DB::table('propiedadxjugador')
                        ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                        ->where('partidaxjugador.idpartida', $objeto->idpartida)
                        ->where('propiedadxjugador.idpropiedad', $propiedad->id)
                        ->select(
                            'partidaxjugador.idpartida',
                            'partidaxjugador.idjugador',
                            'propiedadxjugador.idpropiedad',
                            'propiedadxjugador.tipo',
                            'propiedadxjugador.status',
                            'propiedadxjugador.restaurantes',
                            'propiedadxjugador.hotel'
                        )
                        ->first();
                    $resultado->info_propiedad = $propiedad;
                    if ($pertenece) {
                        $resultado->info_pertenece = $pertenece;
                        $resultado->idjugador = $pertenece->idjugador;
        
                        if ($pertenece->idjugador == $objeto->idjugador) {
                            $resultado->belong = 1;
                            $boturno->cerrar($objeto);
                        } else {
                            $resultado->belong = 0;
                            $objeto3 = new \stdClass();
                            $objeto3->idpropiedad = $propiedad->id;
                            $objeto3->idjugador = $pertenece->idjugador;
                            $objeto3->idpartida = $objeto->idpartida;
                            $precio_nuevo = $this->obtener_precio_aerolinea($objeto3);
                            $resultado->info_propiedad->precio = $precio_nuevo->precio;
                        }
                    } 
                    else {
                        $resultado->idjugador = 0;
                    }
                    
                    break;

                    case 'CONSULADO':
                    
                        /*
                        select 
                            partidasxjugador.idpartida,
                            partidasxjugador.idjugador,
                            propiedadxjugador.idpropiedad,
                            propiedadxjugador.tipo,
                            propiedadxjugador.status,
                            propiedadxjugador.restaurantes,
                            propiedadxjugador.hotel
                        from propiedadxjugador
                        join partidasxjugador on 
                            partidasxjugador.id = propiedadxjugador.idpartidaxjugador
                        where partidasxjugador.idpartida = 2
                        and propiedadxjugador.idpropiedad = 13
                        */
                        $propiedad = Propiedad::find($casilla->idorigen);
                        $pertenece = DB::table('propiedadxjugador')
                            ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                            ->where('partidaxjugador.idpartida', $objeto->idpartida)
                            ->where('propiedadxjugador.idpropiedad', $propiedad->id)
                            ->select(
                                'partidaxjugador.idpartida',
                                'partidaxjugador.idjugador',
                                'propiedadxjugador.idpropiedad',
                                'propiedadxjugador.tipo',
                                'propiedadxjugador.status',
                                'propiedadxjugador.restaurantes',
                                'propiedadxjugador.hotel'
                            )
                            ->first();
                        $resultado->info_propiedad = $propiedad;
                        if ($pertenece) {
                            $resultado->info_pertenece = $pertenece;
                            $resultado->idjugador = $pertenece->idjugador;
            
                            if ($pertenece->idjugador == $objeto->idjugador) {
                                $resultado->belong = 1;
                                $boturno->cerrar($objeto);
                            } else {
                                $resultado->belong = 0;
                                $objeto3 = new \stdClass();
                                $objeto3->idpropiedad = $propiedad->id;
                                $objeto3->idjugador = $pertenece->idjugador;
                                $objeto3->idpartida = $objeto->idpartida;
                                $precio_nuevo = $this->obtener_precio_byc($objeto3);
                                $resultado->info_propiedad->precio = $precio_nuevo->precio;
                            }
                        } 
                        else {
                            $resultado->idjugador = 0;
                        }
                        
                        break;
                        case 'EMBAJADA':
                    
                            /*
                            select 
                                partidasxjugador.idpartida,
                                partidasxjugador.idjugador,
                                propiedadxjugador.idpropiedad,
                                propiedadxjugador.tipo,
                                propiedadxjugador.status,
                                propiedadxjugador.restaurantes,
                                propiedadxjugador.hotel
                            from propiedadxjugador
                            join partidasxjugador on 
                                partidasxjugador.id = propiedadxjugador.idpartidaxjugador
                            where partidasxjugador.idpartida = 2
                            and propiedadxjugador.idpropiedad = 13
                            */
                            $propiedad = Propiedad::find($casilla->idorigen);
                            $pertenece = DB::table('propiedadxjugador')
                                ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
                                ->where('partidaxjugador.idpartida', $objeto->idpartida)
                                ->where('propiedadxjugador.idpropiedad', $propiedad->id)
                                ->select(
                                    'partidaxjugador.idpartida',
                                    'partidaxjugador.idjugador',
                                    'propiedadxjugador.idpropiedad',
                                    'propiedadxjugador.tipo',
                                    'propiedadxjugador.status',
                                    'propiedadxjugador.restaurantes',
                                    'propiedadxjugador.hotel'
                                )
                                ->first();
                            $resultado->info_propiedad = $propiedad;
                            if ($pertenece) {
                                $resultado->info_pertenece = $pertenece;
                                $resultado->idjugador = $pertenece->idjugador;
                
                                if ($pertenece->idjugador == $objeto->idjugador) {
                                    $resultado->belong = 1;
                                    $boturno->cerrar($objeto);
                                } else {
                                    $resultado->belong = 0;
                                    $objeto3 = new \stdClass();
                                    $objeto3->idpropiedad = $propiedad->id;
                                    $objeto3->idjugador = $pertenece->idjugador;
                                    $objeto3->idpartida = $objeto->idpartida;
                                    $precio_nuevo = $this->obtener_precio_byc($objeto3);
                                    $resultado->info_propiedad->precio = $precio_nuevo->precio;
                                }
                            } 
                            else {
                                $resultado->idjugador = 0;
                            }
                            
                            break;
        }
        //dd($resultado);
        return $resultado;
    }
    

/*
* Modificar el dinero de un jugador en una partida.
*/
function modifica_dinero($objeto) {
$resultado = new \StdClass();

// 1.- Modifico el campo dinero de Partidaxjugador
$par = PartidaxJugador::where('idjugador', $objeto->idjugador)
    ->where('idpartida', $objeto->idpartida)
    ->first();

$par->dinero = $par->dinero + $objeto->dinero;
$resultado->perdio = 0;

// Si el dinero es menor a 0, el jugador pierde
if ($par->dinero < 0) {
    $resultado->perdio = 1;
    $par->dinero = 0;
    $par->status = 0;
}

$par->save();
return $resultado;
}

/*
* Comprar una propiedad para un jugador en una partida.
*/
function comprar_propiedad($objeto) {
$boturno = new BoTurno();

// 1.- Agregar la propiedad al jugador en la partida
$prp = new Propiedadxjugador();
$prp->idpropiedad = $objeto->idpropiedad;
$prp->restaurantes = 0;
$prp->hotel = 0;
$prp->status = 1;
$prp->tipo = 'PROPIEDAD';

// Asociar la propiedad al jugador en la partida
$par = PartidaxJugador::where('idjugador', $objeto->idjugador)
    ->where('idpartida', $objeto->idpartida)
    ->first();
$prp->idpartidaxjugador = $par->id;
$prp->save();

// 2.- Descontar el dinero del jugador
$objeto->dinero = $objeto->dinero*-1;

// Cierro el turno
$boturno->cerrar($objeto);

return $this->modifica_dinero($objeto);
}


function comprar_Linea_Area($objeto) {
    $boturno = new BoTurno();
    
    // 1.- Agregar la propiedad al jugador en la partida
    $prp = new Propiedadxjugador();
    $prp->idpropiedad = $objeto->idpropiedad;
    $prp->restaurantes = 0;
    $prp->hotel = 0;
    $prp->status = 1;
    $prp->tipo = 'LINEA AEREA';
    
    // Asociar la propiedad al jugador en la partida
    $par = PartidaxJugador::where('idjugador', $objeto->idjugador)
        ->where('idpartida', $objeto->idpartida)
        ->first();
    $prp->idpartidaxjugador = $par->id;
    $prp->save();
    
    // 2.- Descontar el dinero del jugador
    $objeto->dinero = $objeto->dinero*-1;
    
    // Cierro el turno
    $boturno->cerrar($objeto);
    
    return $this->modifica_dinero($objeto);
    }




    function comprar_Embajada($objeto) {
        $boturno = new BoTurno();
        
        // 1.- Agregar la propiedad al jugador en la partida
        $prp = new Propiedadxjugador();
        $prp->idpropiedad = $objeto->idpropiedad;
        $prp->restaurantes = 0;
        $prp->hotel = 0;
        $prp->status = 1;
        $prp->tipo = 'EMBAJADA';
        
        // Asociar la propiedad al jugador en la partida
        $par = PartidaxJugador::where('idjugador', $objeto->idjugador)
            ->where('idpartida', $objeto->idpartida)
            ->first();
        $prp->idpartidaxjugador = $par->id;
        $prp->save();
        
        // 2.- Descontar el dinero del jugador
        $objeto->dinero = $objeto->dinero*-1;
        
        // Cierro el turno
        $boturno->cerrar($objeto);
        
        return $this->modifica_dinero($objeto);
        }

        function comprar_Consulado($objeto) {
            $boturno = new BoTurno();
            
            // 1.- Agregar la propiedad al jugador en la partida
            $prp = new Propiedadxjugador();
            $prp->idpropiedad = $objeto->idpropiedad;
            $prp->restaurantes = 0;
            $prp->hotel = 0;
            $prp->status = 1;
            $prp->tipo = 'CONSULADO';
            
            // Asociar la propiedad al jugador en la partida
            $par = PartidaxJugador::where('idjugador', $objeto->idjugador)
                ->where('idpartida', $objeto->idpartida)
                ->first();
            $prp->idpartidaxjugador = $par->id;
            $prp->save();
            
            // 2.- Descontar el dinero del jugador
            $objeto->dinero = $objeto->dinero*-1;
            
            // Cierro el turno
            $boturno->cerrar($objeto);
            
            return $this->modifica_dinero($objeto);
            }
/*
Atributos que tiene el objeto
idjugador
idpartida
dinero
idpropiedad
*/
function pagar_renta($objeto) {
    // 1.- Quito el dinero al jugador del turno
    $objeto->dinero = $objeto->dinero * -1;
    $res = $this->modifica_dinero($objeto);

    // 2.- Aumentar el dinero al jugador que le pertenece la propiedad en la partida
    /*
    select partidaxjugador.idjugador
    from partidaxjugador
    join propiedadxjugador on partidaxjugador.id = propiedadxjugador.idpartidaxjugador
    where propiedadxjugador.idpropiedad = 2
    and partidaxjugador.idjugador = 2
    and partidaxjugador.idpartida = 10
    */

    $boturno = new BoTurno();
    $boturno->cerrar($objeto);

    $info_pertenece = DB::table('propiedadxjugador')
        ->join('partidaxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
        ->where('partidaxjugador.idpartida', $objeto->idpartida)
        ->where('propiedadxjugador.idpropiedad', $objeto->idpropiedad)
        ->select(
            'partidaxjugador.idjugador',
            'propiedadxjugador.tipo',
            'propiedadxjugador.status',
            'propiedadxjugador.restaurantes',
            'propiedadxjugador.hotel'
        )
        ->first();

    // dd($info_pertenece);

    $objeto->idjugador = $info_pertenece->idjugador;
    $objeto->dinero = $objeto->dinero * -1;

    $this->modifica_dinero($objeto);
}








    
function obtener_propiedades_jugador($objeto) {
    $resultado = new \StdClass();

    // Consultar propiedades del jugador en la partida
    $propiedades = DB::table('partidaxjugador')
        ->join('propiedadxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
        ->join('propiedad', 'propiedad.id', '=', 'propiedadxjugador.idpropiedad')
        ->where('partidaxjugador.idpartida', $objeto->idpartida)
        ->where('partidaxjugador.idjugador', $objeto->idjugador)
        ->select(
            'propiedad.nombre as nombre_propiedad',
            'propiedadxjugador.tipo',
            'propiedadxjugador.restaurantes',
            'propiedadxjugador.hotel'
        )
        ->get();

    // Preparar los datos para el resultado
    $resultado->propiedades = $propiedades;
    $resultado->cantidad = $propiedades->count();
    $resultado->mensaje = "Propiedades del jugador en la partida obtenidas correctamente.";
    
    return $resultado;
}

function obtener_propiedades_con_precios($objeto) {
    $resultado = new \StdClass();

    // Consultar propiedades del jugador con precios de restaurantes y hotel
    $propiedades = DB::table('partidaxjugador')
        ->join('propiedadxjugador', 'partidaxjugador.id', '=', 'propiedadxjugador.idpartidaxjugador')
        ->join('propiedad', 'propiedad.id', '=', 'propiedadxjugador.idpropiedad')
        ->where('partidaxjugador.idpartida', $objeto->idpartida)
        ->where('partidaxjugador.idjugador', $objeto->idjugador)
        ->select(
            'propiedad.id as id_propiedad',
            'propiedad.nombre as nombre_propiedad',
            'propiedad.r1',
            'propiedad.r2',
            'propiedad.r3',
            'propiedad.hotel',
            'propiedadxjugador.restaurantes',
            'propiedadxjugador.hotel'
        )
        ->get();

    // Preparar los datos para el resultado
    $resultado->propiedades = $propiedades;
    $resultado->cantidad = $propiedades->count();
    $resultado->mensaje = "Propiedades y precios obtenidos correctamente.";
    
    return $resultado;
}


}


    
    
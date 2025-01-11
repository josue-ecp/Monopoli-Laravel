<?php

namespace App\BusinessLogic;

use Illuminate\Support\Facades\DB; 
use App\Models\Partida;
use App\Models\Partidaxjugador;
class BoPartida{
/*
El objeto tiene 3 atributos
$clave
$nombre
$fecha (opcional)
$idjugador
*/
function crear($objeto){
$resultado=new \StdClass();
$p=new Partida();
//Tratamiento de los valores de entrada 
$p->nombre=$objeto->nombre;
$p->clave=$objeto->clave;
$p->idjugador=$objeto->idjugador;
$p->status=0;
$p->turno=0;
//Me interesa detectar true 
if($this->validar_clave ($objeto)){ 
    $resultado->status='Not OK';
    $resultado->mensaje='Ya existe la clave '.$objeto->clave; 
    //return $resultado;
    return view('partida.clave_existente');
}

if(!isset($objeto->fecha)){
    $objeto->fecha=hoy();
}

$p->fecha=$objeto->fecha;
$p->save();
$objeto2=new \StdClass();
$objeto2->idjugador=$objeto->idjugador;
$objeto2->idpartida=$p->id;
$this->unir($objeto2);
$resultado->status = 'OK';
return $resultado;
}
/*
El objeto tiene 3 atributos
$idjugador
$idpartida
$dinero opcional
*/
function unir($objeto){
    $resultado=new \StdClass();
    $pxjug=new Partidaxjugador();
    /*if(!isset($objeto->idpartida)){
        $partida=DB::table('partida')->where('clave',$objeto->clave)->first();
        $objeto->idpartida=$partida->id;
    }*/
        // Validar si la clave existe
        if (!isset($objeto->idpartida)) {
            $partida = DB::table('partida')->where('clave', $objeto->clave)->first();
            if (!$partida) {
                $resultado->status = 'Not OK';
                $resultado->mensaje = 'La clave proporcionada no existe';
                return $resultado;
            }
            $objeto->idpartida = $partida->id;
        }
    $pxjug->idpartida=$objeto->idpartida;
    $pxjug->idjugador=$objeto->idjugador;
    $pxjug->turno=0;
    $pxjug->status=1;
    $pxjug->posicion=1;
    if(!isset($objeto->dinero)){
        $objeto->dinero=150000;
    }
    $pxjug->dinero=$objeto->dinero;

    //Valido si ya esta el cupo completo
    //Necesito detectar false
    if(!$this->validar_numparticipantes($objeto)){
        $resultado->status='Not OK';
        $resultado->mensaje='Ya Se han superado el numero de participantes';
        return $resultado;
    }

    //Valido si ya me inscribi Necesito detectar true
    if($this->validar_participacion($objeto)){
        $resultado->status='Not OK';
        $resultado->mensaje='Ya te has inscrito previamente a la partida';
        return $resultado;
    }

    $resultado->status='OK';
    $pxjug->save();
    $resultado->id=$pxjug->id;
    return $resultado;
}

//Este validar esta definido para que solo recupere un registro
function validar_clave($objeto){
    $partida=DB::table('partida')->where('clave',$objeto->clave)->first();
    if($partida){
        return $partida;
    }else
        return false;
}

/*
El objeto tiene los siguientes atributos
idjugador
clave
idpartida
*/
function validar_participacion($objeto){
    $partidaxjugador=DB::table('partidaxjugador')
        ->where('idjugador', $objeto->idjugador)
        ->where('idpartida', $objeto->idpartida)
        ->first();
    if($partidaxjugador)
        return $partidaxjugador;
    else
        return false;
}

function validar_numparticipantes($objeto){
    $partidaxjugador=DB::table('partidaxjugador')
        ->where('idpartida', $objeto->idpartida)
        ->get();

    //Preguntamos si el numero de participantes ya se excedió
    if(count($partidaxjugador) >= 6){
        return false;
    } 
    else{
        return true;
    }
}

/*
select partida.nombre
      ,partida.clave
      ,partida.status
      ,partida.idjugador
      ,partida.id
      ,partida.fecha
from partida
join partidaxjugador on partidaxjugador.idpartida=partida.id
where partidaxjugador.idjugador=2
El objeto tiene el atributo de idjugador
*/

function Listar_partidas_jugador($objeto){
    return DB::table('partida')
        ->join('partidaxjugador', 'partidaxjugador.idpartida', '=', 'partida.id')
        ->where('partidaxjugador.idjugador', $objeto->idjugador)
        ->select(
            'partida.nombre',
            'partida.clave',
            'partida.status',
            'partida.idjugador',
            'partida.id',
            'partida.fecha'
        )
        ->get();
}
/*
El objeto tiene el atributo idpartida
*/
function iniciar($objeto){
    //1.-Cambiar el status de la partida en 1 y le pongo el turno 1
    $j=Partida::find($objeto->idpartida);
    $j->status=1;
    $j->turno=1;
    $j->save();

    //2.-Asignar los turnos a los jugadores
    //2.1 Obtener cuántos jugadores tiene la partida
    $partidaxjugador=DB::table('partidaxjugador')
        ->where('idpartida', $objeto->idpartida)
        ->get();
    $numero_jugadores=count($partidaxjugador);

    //2.2 Un arreglo de n números de acuerdo al número de jugadores
    $turnos=range(1, $numero_jugadores);
    shuffle($turnos);

    //2.3 Asignar los turnos a los jugadores
    //También les asigno la posición inicial
    $jugadores=Partidaxjugador::where('idpartida', $objeto->idpartida)->get();
    $indice_turnos=0;
    foreach($jugadores as $jugador){
        $jugador->turno=$turnos[$indice_turnos];
        //$jugador->turno=1;
        $indice_turnos++;
        $jugador->save();
    }
}

//El objeto tiene los atributos
//idpartida
//idjugador
function validar_turno($objeto){
    $resultado=new \StdClass();
    //Si el turno que tiene la partida
    $j=Partida::find($objeto->idpartida);
    //Obtener el turno que tiene el jugador en la partida
    $partidaxjugador=DB::table('partidaxjugador')
        ->where('idjugador', $objeto->idjugador)
        ->where('idpartida', $objeto->idpartida)
        ->first();

    //Comparo los turnos de la partida y del jugador
    if($j->turno==$partidaxjugador->turno){
        $resultado->status='OK';
        $resultado->info=$partidaxjugador;
    } 
    else{
        $resultado->status='NotOK';
    }
    return $resultado;
}
}
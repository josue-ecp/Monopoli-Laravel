<?php
namespace App\BusinessLogic;

use Illuminate\Support\Facades\DB;
use App\Models\Partida;
use App\Models\Partidaxjugador;
use App\Models\Turno;
use App\BusinessLogic\BoControl;

class BoTurno{
    // El objeto tiene los atributos
    // idpartida
    // idjugador
    
    function obtener_turno($objeto){
        return Partidaxjugador::where('idpartida', $objeto->idpartida)
            ->where('idjugador', $objeto->idjugador)
            ->first();
    }
    
    // El objeto tiene los atributos
    // casilla
    // Puede caer en
    // Propiedad
    // Aeropuerto
    // Salida / México
    // Carta / Telegrama
    // Detenida
    // Donación
    // Embajada / Consulado
    // Visas
    // Aduana
    // Imigración
    
   /* function info_casilla($objeto){
        $resultado = new \StdClass();
        $resultado->tipo = 'Salida';
        // Si el atributo ocupado vale 0 significa que está libre
        // De otra forma indica el jugador que tiene esa propiedad
        $resultado->ocupado = 1;
        $resultado->precio = 18000;
        $resultado->nombre = 'Inglaterra';
        return $resultado;
    }*/
    
    
    // El objeto tiene los atributos
    // idpartida
    // idjugador
    
    function jugar($objeto){
        $bocontrol = new BoControl();
        $resultado = new \StdClass();

        // 1.- Validar si ya inicie mi turno
        $turno = $this->validar_turno_abierto($objeto);
        if($turno){
            // 1.1 Si ya lo inicie obtengo en que posición me quedé
            $nueva_posicion = $turno->posicion;
        } 
        else {
            // 1.2 Si no he iniciado mi turno
            // 1.1.- Tirar dados
            $dados = tirar_dados();
            // 2.- Mover al jugador
            $info_turno = $this->obtener_turno($objeto);
            $nueva_posicion = $info_turno->posicion+$dados;
            // Este proceso contempla el caso en el que llegue al final del tablero y se pase de la salida
            if($nueva_posicion > 40){
                $nueva_posicion = $nueva_posicion - 40;
            }
            
            // Iniciar mi turno
            $objeto->posicion = $nueva_posicion;
            $this->crear($objeto);
            
        }

      $nueva_posicion=2;
        
        // 3.- Obtener la información de la casilla
        $objeto2 = new \StdClass();
        $objeto2->posicion = $nueva_posicion;
        $objeto2->idjugador = $objeto->idjugador;
        $objeto2->idpartida = $objeto->idpartida;
        $res1 = $bocontrol->info_casilla($objeto2);
        //$this->crear($objeto2);
        return $res1;
        
    }

    

    /*
    * idpartida
    * idjugador
    * posicion
    */

    function crear($objeto){
        // dd($objeto);
        // 1.- Recuperar con la partida y el jugador el idpartidaxjugador
        $partidaxjugador = $this->obtener_turno($objeto);


        // 2.- Insertar en la tabla turnos el registro
        $turno = new Turno();
        // Turno significa que no ha terminado mi turno, 1 significa que ya termino
        $turno->status = 0;
        $turno->idpartidaxjugador = $partidaxjugador->id;
        $turno->posicion = $objeto->posicion;
        $turno->save();
        return $turno;
    }

    function validar_turno_abierto($objeto){
        $turno = DB::table('partidaxjugador')
            ->join('turno', 'turno.idpartidaxjugador', 'partidaxjugador.id')
            ->where('partidaxjugador.idpartida', $objeto->idpartida)
            ->where('partidaxjugador.idjugador', $objeto->idjugador)
            ->where('turno.status', 0)
            ->first();
        if($turno)
            return $turno;
         else 
            return false;
        
    }

    /*
    * idpartida
    * idjugador
    */

    function cerrar($objeto){
        // 1.- Modificar el status del turno
        //dd($objeto);
        $partidaxjugador = $this->obtener_turno($objeto);
        $turno = Turno::where('idpartidaxjugador', $partidaxjugador->id)
            ->where('status', 0)->first();
        $turno->status = 1;
        $turno->save();

        // 2.- Aumentar el turno de la partida para indicar al siguiente jugador
        $turno_nuevo = $partidaxjugador->turno + 1;
        // 2.1.- Obtener el número de jugadores de la partida
        $jugadores = Partidaxjugador::where('idpartida', $objeto->idpartida)
            ->get();
        // 2.2.- Verificar si el número que obtenemos es mayor al número de jugadores
        if($turno_nuevo > count($jugadores)){
            // 2.3 Si es así se reinicia en 1
            $turno_nuevo = 1;
        }
        // 3.- Guardar en la partida el siguiente turno
        $partida = Partida::find($objeto->idpartida);
        $partida->turno = $turno_nuevo;
        $partida->save();
    }
}
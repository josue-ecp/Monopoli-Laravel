<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Jugador;
use App\BusinessLogic\BoPartida;
use Illuminate\Support\Facades\DB;


class JugadorController extends Controller
{
    // Código del catálogo arriba
    function registrate(){
        $datos = array();
        return view('app.register')->with($datos);
    }

    // Permitir a los usuarios registrarse como Jugadores
    function autoregistro(Request $r){
        $datos = $r->all();
        $archivo = $r->file('foto');
        // 1. Insertar un usuario
        $j = new Usuario();
        $j->email = $datos['email'];
        if($datos['password'] != ''){
            $j->password = bcrypt($datos['password']);
        }
        
        // Aquí se le pone manualmente el idrol 2 porque estamos registrando a un jugador
        $j->idrol = 2;
        $j->save();
        
        // 2. Insertar un jugador
        $jugador = new Jugador();
        $jugador->nombre = $datos['nombre'];
        $jugador->edad = $datos['edad'];
        $jugador->foto = '';
        $jugador->save();
        // Subir el archivo en el filesystem
        // Validar si el usuario está subiendo un archivo
        if($r->hasFile('foto')){
            // Si el usuario subió un archivo
            $nombre_archivo = 'jugador-' . $jugador->id . '.' . $archivo->getClientOriginalExtension();
            // Subir el archivo
            // Tratamiento del archivo
            $archivo->storeAs('fotos/jugador', $nombre_archivo);

            // Relacionar el archivo con el registro de la bd
            $jugador->foto = $nombre_archivo;}
        // Establezco la relación entre la tabla personaje y la tabla usuario
        $jugador->idusuario = $j->id;
        $jugador->save();
        
        // 3. Hacer el Login
        // LOGIN AUTOMATICO
        Auth::loginUsingId($j->id);
        // 4. Redirigir a la página de bienvenida
        return redirect()->route('home_jugador');
    }

    /*function home(){
        // 1. Recupero al usuario que inició sesión
        $usuario = Auth::user();
        
        // 2. Obtengo al jugador relacionado al usuario
        $jugador = Jugador::where('idusuario', $usuario->id)->first();
        $nombre = $jugador->nombre;
        $bo=new BoPartida();
        $objeto=new \stdClass();
        $objeto->idjugador=$jugador->id;
        // Recuperar de la sesión al USUARIO
        $datos = array();
        $datos['nombre'] = $nombre;
        $datos['partidas'] = $bo->Listar_partidas_jugador($objeto);
        //dd('Hola!!!!!'.$nombre );
        return view('home.jugador')->with($datos);
    }*/

    function home() {
        // 1. Recupero al usuario que inició sesión
        $usuario = Auth::user();
        
        // 2. Obtengo al jugador relacionado al usuario
        $jugador = Jugador::where('idusuario', $usuario->id)->first();
        $nombre = $jugador->nombre;
        
        // 3. Inicializo el objeto para las partidas
        $bo = new BoPartida();
        $objeto = new \stdClass();
        $objeto->idjugador = $jugador->id;
        
        // 4. Recupero las partidas del jugador
        $partidas = $bo->Listar_partidas_jugador($objeto);
    
        // 5. Para cada partida, obtengo el dinero asociado al jugador
        $partidas = $partidas->map(function($partida) use ($jugador) {
            // Accedo a idpartida de la partida
            $dinero = DB::table('partidaxjugador')
                ->where('idjugador', $jugador->id)
                ->where('idpartida', $partida->id) // Ahora 'idpartida' está disponible
                ->value('dinero');
            $partida->dinero = $dinero ?? 0; // Si no hay registro, asigna 0 como valor predeterminado
            return $partida;
        });
    
        // 6. Preparo los datos para la vista
        $datos = [
            'nombre' => $nombre,
            'partidas' => $partidas // Mantengo la clave original
        ];
        
        // 7. Retorno la vista con los datos
        return view('home.jugador')->with($datos);
    }
    

    // Nuevo código adaptado
    function listado(){
        $datos = array();
        // Este método del modelo obtiene todos los datos de la tabla Jugador
        $datos['jugadores'] = Jugador::all();
        // jugador.listado significa que hay una carpeta llamada jugador y ahí hay un archivo que se llama listado
        return view('jugador.listado')->with($datos);
    }

    function formulario($id = 0){
        $datos = array();
        if($id == 0){
            // Agregar
            $datos['operacion'] = 'Agregar';
            $jugador = new Jugador();
            $jugador->id = 0;
        } else {
            // Modificar
            $datos['operacion'] = 'Modificar';
            // El método find sirve para recuperar información del modelo por medio del id
            $jugador = Jugador::find($id);
        }
        $datos['jugador'] = $jugador;
        return view('jugador.formulario')->with($datos);
    }

    function operaciones(Request $r){
        $datos = $r->all();
        // Leo el archivo que subió el usuario
        $archivo = $r->file('foto');
        switch ($datos['operacion']) {
            case 'Agregar':
                // Insertar el registro en la bd
                $j = new Jugador();
                $j->nombre = $datos['nombre'];
                $j->edad = $datos['edad'];
                $j->foto = '';
                $j->save();

                // Subir el archivo en el filesystem
                // Validar si el usuario está subiendo un archivo
                if($r->hasFile('foto')){
                    // Si el usuario subió un archivo
                    $nombre_archivo = 'jugador-' . $j->id . '.' . $archivo->getClientOriginalExtension();
                    // Subir el archivo
                    // Tratamiento del archivo
                    $archivo->storeAs('fotos/jugador', $nombre_archivo);

                    // Relacionar el archivo con el registro de la bd
                    $j->foto = $nombre_archivo;
                    $j->save();
                }
                break;

            case 'Modificar':
                // Recupero al modelo para editarlo y saber si tiene una foto asociada
                $j = Jugador::find($datos['id']);
                $j->nombre = $datos['nombre'];
                $j->edad = $datos['edad'];

                // Validamos si el usuario subió una foto o no
                if($r->hasFile('foto')){
                    // 1.- Elimino el archivo anterior
                    // Valido si anteriormente el registro tenía una foto asociada
                    if($j->foto != ''){
                        Storage::delete('fotos/jugador/' . $j->foto);
                    }

                    // 2.- Subir la foto nueva
                    // Si el usuario subió un archivo
                    $nombre_archivo = 'jugador-' . $j->id . '.' . $archivo->getClientOriginalExtension();
                    // Subir el archivo
                    // Tratamiento del archivo
                    $archivo->storeAs('fotos/jugador', $nombre_archivo);

                    // Relacionar el archivo con el registro de la bd
                    $j->foto = $nombre_archivo;
                }
                $j->save();
                break;

            case 'Eliminar':
                // Recupero la información de la bd
                $j = Jugador::find($datos['id']);

                // Valido si el registro de la bd tiene una foto asociada
                if($j->foto != ''){
                    // Borro el archivo del servidor
                    Storage::delete('fotos/jugador/' . $j->foto);
                }
                $j->delete();
                break;
        }
        return redirect()->route('index_jugador');
    }

    public function mostrar_foto($nombre_foto){
        // storage_path es una función de Laravel que devuelve la ruta real del archivo dentro de la carpeta Storage
        $path = storage_path('app/fotos/jugador/' . $nombre_foto);
        if (!File::exists($path)) {
            // Error 404 significa que no encontró el archivo
            abort(404);
        }

        // Recuperar el contenido del archivo
        $file = File::get($path);
        // Recuperar el tipo de archivo
        $type = File::mimeType($path);
        // Devuelvo el archivo
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}


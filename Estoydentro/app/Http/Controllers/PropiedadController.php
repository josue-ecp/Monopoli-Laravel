<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Propiedad;
use App\Models\Tipopropiedad; // Modelo de Tipopropiedad
use App\Models\Region; // Modelo de Region

class PropiedadController extends Controller
{
    function listado(){
        $datos=array();
        //Este metodo del modelo obtiene todos los datos de la tabla //Propiedad
        //$datos['propiedades']=Propiedad::all();
        $datos['propiedades'] = Propiedad::join('region', 'propiedad.idregion', '=', 'region.id')
    ->join('tipopropiedad', 'propiedad.idtipopropiedad', '=', 'tipopropiedad.id')
    ->select(
        'region.nombre AS idregion',
        'tipopropiedad.nombre AS idtipopropiedad',
        'propiedad.id',
        'propiedad.nombre',
        'propiedad.precio',
        'propiedad.orden',
        'propiedad.foto'
    )
    ->get();
        //propiedad.listado significa que hay una carpeta
        //llamada propiedad y ahi hay un archivo que se llama
        //listado
        return view('propiedad.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            //Agregar
            $datos['operacion']='Agregar';
            $propiedad=new Propiedad();
            $propiedad->id=0;
        } else {
            //Modificar
            $datos['operacion']='Modificar';
            //El metodo find sirve para recuperar informacion
            //del modelo por medio del id
            $propiedad=Propiedad::find($id);
        }
        $datos['propiedad']=$propiedad;

         // Obtener todas las opciones de tipos de propiedad y regiones
         $datos['tipos_propiedad'] = Tipopropiedad::all();
         $datos['regiones'] = Region::all();
        return view('propiedad.formulario')->with($datos);
    }
    
    function operaciones(Request $r){
        $datos=$r->all();
        //leo el archivo que subio el usuario
        $archivo=$r->file('foto');
        switch ($datos['operacion']) {
            case 'Agregar':
                //Insertar el registro en la bd
                $j=new Propiedad();
                $j->nombre=$datos['nombre'];
                $j->precio=$datos['precio'];
                $j->idtipopropiedad=$datos['idtipopropiedad'];
                $j->idregion=$datos['idregion'];
                $j->orden=$datos['orden'];
                $j->foto='';
                $j->save();

                //Subir el archivo en el filesystem
                //Validar si el usuario esta subiendo un archivo
                if($r->hasFile('foto')){
                    //Si el usuario subio un archivo
                    $nombre_archivo='propiedad-'.$j->id.'.'.$archivo->getClientOriginalExtension();
                    //Subir el archivo
                    //Tratamiento del archivo
                    $archivo->storeAs('fotos/propiedad', $nombre_archivo);

                    //Relacionar el archivo con el registro de la bd
                    $j->foto=$nombre_archivo;
                    $j->save();
                }
                break;

            case 'Modificar':
                //Recupero al modelo para editarlo y saber si tiene una foto
                //asociada
                $j=Propiedad::find($datos['id']);
                $j->nombre=$datos['nombre'];
                $j->precio=$datos['precio'];
                $j->idtipopropiedad=$datos['idtipopropiedad'];
                $j->idregion=$datos['idregion'];
                $j->orden=$datos['orden'];

                //Validamos si el usuario
                //subio una foto o no
                if($r->hasFile('foto')){
                    //1.-Elimino el archivo anterior
                    //Valido si anteriormente el registro tenia una foto Asociada
                    if($j->foto!=''){
                        Storage::delete('fotos/propiedad/'.$j->foto);
                    }

                    //2.-Subir la foto nueva
                    //Si el usuario subio un archivo
                    $nombre_archivo='propiedad-'.$j->id.'.'.$archivo->getClientOriginalExtension();
                    //Subir el archivo
                    //Tratamiento del archivo
                    $archivo->storeAs('fotos/propiedad', $nombre_archivo);

                    //Relacionar el archivo con el registro de la bd
                    $j->foto=$nombre_archivo;
                   
                }
                $j->save();
                break;

            case 'Eliminar':
                //Recupero la informacion de la bd
                $j=Propiedad::find($datos['id']);

                //Valido si el registro de la bd tiene
                //una foto asociada
                if($j->foto!=''){
                    //Borro el archivo del servidor
                    Storage::delete('fotos/propiedad/'.$j->foto);
                }
                $j->delete();
                break;
        }
        return redirect()->route('index_propiedad');
    }

    public function mostrar_foto($nombre_foto){
        //storage_path es una funcion de laravel que devuelve la ruta real del archivo dentro
        //de la carpeta Storage
        $path = storage_path('app/fotos/propiedad/'.$nombre_foto);
        if (!File::exists($path)) {
            //Error 404 significa que no encontro el archivo
            abort(404);
        }

        //recuperar el contenido del archivo
        $file = File::get($path);
        //recuperar el tipo de archivo
        $type = File::mimeType($path);
        //devuelvo el archivo
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}

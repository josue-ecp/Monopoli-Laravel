<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Region;


class RegionController extends Controller
{
    function listado(){
        $datos=array();
        //Este metodo del modelo obtiene todos los datos de la tabla //Region
        $datos['regiones']=Region::all();
        //region.listado significa que hay una carpeta
        //llamada region y ahi hay un archivo que se llama
        //listado
        return view('region.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            //Agregar
            $datos['operacion']='Agregar';
            $region=new Region();
            $region->id=0;
        } else {
            //Modificar
            $datos['operacion']='Modificar';
            //El metodo find sirve para recuperar informacion
            //del modelo por medio del id
            $region=Region::find($id);
        }
        $datos['region']=$region;
        return view('region.formulario')->with($datos);
    }

    function operaciones(Request $r){
        $datos=$r->all();
        //leo el archivo que subio el usuario
        $archivo=$r->file('foto');
        switch ($datos['operacion']) {
            case 'Agregar':
                //Insertar el registro en la bd
                $j=new Region();
                $j->nombre=$datos['nombre'];
                $j->color=$datos['color'];
                $j->foto='';
                $j->save();

                //Subir el archivo en el filesystem
                //Validar si el usuario esta subiendo un archivo
                if($r->hasFile('foto')){
                    //Si el usuario subio un archivo
                    $nombre_archivo='region-'.$j->id.'.'.$archivo->getClientOriginalExtension();
                    //Subir el archivo
                    //Tratamiento del archivo
                    $archivo->storeAs('fotos/region', $nombre_archivo);

                    //Relacionar el archivo con el registro de la bd
                    $j->foto=$nombre_archivo;
                    $j->save();
                }
                break;

            case 'Modificar':
                //Recupero al modelo para editarlo y saber si tiene una foto
                //asociada
                $j=Region::find($datos['id']);
                $j->nombre=$datos['nombre'];
                $j->color=$datos['color'];

                //Validamos si el usuario
                //subio una foto o no
                if($r->hasFile('foto')){
                    //1.-Elimino el archivo anterior
                    //Valido si anteriormente el registro tenia una foto Asociada
                    if($j->foto!=''){
                        Storage::delete('fotos/region/'.$j->foto);
                    }

                    //2.-Subir la foto nueva
                    //Si el usuario subio un archivo
                    $nombre_archivo='region-'.$j->id.'.'.$archivo->getClientOriginalExtension();
                    //Subir el archivo
                    //Tratamiento del archivo
                    $archivo->storeAs('fotos/region', $nombre_archivo);

                    //Relacionar el archivo con el registro de la bd
                    $j->foto=$nombre_archivo;
                   
                }
                $j->save();
                break;

            case 'Eliminar':
                //Recupero la informacion de la bd
                $j=Region::find($datos['id']);

                //Valido si el registro de la bd tiene
                //una foto asociada
                if($j->foto!=''){
                    //Borro el archivo del servidor
                    Storage::delete('fotos/region/'.$j->foto);
                }
                $j->delete();
                break;
        }
        return redirect()->route('index_region');
    }

    public function mostrar_foto($nombre_foto){
        //storage_path es una funcion de laravel que devuelve la ruta real del archivo dentro
        //de la carpeta Storage
        $path = storage_path('app/fotos/region/'.$nombre_foto);
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

<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Incluyo el modelo para poder ser utilizado en el controlador
use App\Models\Permiso;
use App\Models\RolxPermiso;
// Esta clase sirve para manejar los datos de la sesión del usuario
use Illuminate\Support\Facades\Auth;

class RolxPermisoController extends Controller
{
   function formulario($id){
    $datos=array();
    $datos['id']=$id;
   
    $temp=Permiso::all();
    for($i=0;$i<count($temp);$i++){
        $validacion=RolxPermiso::where('idrol',$id)->where('idpermiso',$temp[$i]->id)->first();
        if($validacion)
        $temp[$i]->asignado=true;
        else
        $temp[$i]->asignado=false;
    }


    $datos['permisos']=$temp;
    return view('rolxpermiso.formulario')->with($datos);

   }

   function save(Request $r){
    $context=$r->all();

    RolxPermiso::where('idrol',$context['idrol'])->delete();



    if (isset($context['idpermiso'])){
        foreach($context['idpermiso']as $idpermiso){
            $rolxpermiso=new RolxPermiso();
            $rolxpermiso->idrol=$context['idrol'];
            $rolxpermiso->idpermiso=$idpermiso;
            $rolxpermiso->save();
    
        }

    }

  
    return redirect()->route('index_rol');
}
}
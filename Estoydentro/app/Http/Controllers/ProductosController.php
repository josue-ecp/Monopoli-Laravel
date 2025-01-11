<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Productos::all();
        return view('productos.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            $datos['productos']=new Productos();
            $datos['operation']='Agregar';
        }
        else{
            $datos['productos']=Productos::find($id);
            $datos['operation']='Modificar'; 
        }
        return view('productos.formulario')->with($datos);

    }

    function save(Request $r){
        $context=$r->all();
        switch($context['operation']){
            case 'Agregar':
                $productos=new Productos();
                $productos->nombre=$context['nombre'];
                $productos->claveproducto=$context['claveproducto'];
                $productos->tallas=$context['tallas'];
                $productos->precio=$context['precio'];
                /*if ($r->hasFile('img')) {
                    $productos->img = file_get_contents($r->file('img')->getRealPath());
                }*/
                if ($r->hasFile('img')) {
                    $productos->img = file_get_contents($r->file('img')->getRealPath());
                }
                $productos->save();
            break;
            case 'Modificar':
                $productos=Productos::find($context['id']);
                $productos->nombre=$context['nombre'];
                $productos->claveproducto=$context['claveproducto'];
                $productos->tallas=$context['tallas'];
                $productos->precio=$context['precio'];
                /*if ($r->hasFile('img')) {
                    $productos->img = file_get_contents($r->file('img')->getRealPath());
                }*/
                if ($r->hasFile('img')) {
                    $productos->img = file_get_contents($r->file('img')->getRealPath());
                }
                $productos->save();
            break;
            case 'Eliminar':
                $productos=Productos::find($context['id']);
                $productos->delete();
            break;
        }
        return redirect()->route('index_productos');
    }

}
<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\items;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Items::all();
        return view('items.listado')->with($datos);
    }

    function formulario($id=0){
        $datos=array();
        if($id==0){
            $datos['items']=new Items();
            $datos['operation']='Agregar';
        }
        else{
            $datos['items']=Items::find($id);
            $datos['operation']='Modificar'; 
        }
        return view('items.formulario')->with($datos);

    }

    function save(Request $r){
        $context=$r->all();
        switch($context['operation']){
            case 'Agregar':
                $items=new Items();
                $items->nombre=$context['nombre'];
                $items->save();
            break;
            case 'Modificar':
                $items=Items::find($context['id']);
                $items->nombre=$context['nombre'];
                $items->save();
            break;
            case 'Eliminar':
                $items=Items::find($context['id']);
                $items->delete();
            break;
        }
        return redirect()->route('index_items');
    }
}
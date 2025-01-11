<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller{
    function index(){
        $datos=array();
        $datos['registros']=Productos::all();
        return view('landingpage.prin')->with($datos);
    }
   
}
@extends('app.master')

@section('titulo')
Deportado
@endsection

@section('contenido')
<div class="ibox ">
    <div class="ibox-title">
        <h5>Salida</h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                Caíste en Deportado<br/>
                Te descontaron $5,000 y te llevamos a Groenlandia
                @if($casilla->perdio==1)
                Ya perdiste
                @endif
            </div>
        </div>
        <div class="row">
        </div>
    </div>
</div>
@endsection
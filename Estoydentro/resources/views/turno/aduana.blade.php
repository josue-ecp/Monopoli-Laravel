@extends('app.master')

@section('titulo')
Aduana
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
                Caíste en Aduana<br/>
                Te descontaron el 10% de tu dinero<br/>
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
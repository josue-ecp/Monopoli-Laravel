@extends('app.master')

@section('titulo')
Carta
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
                Caíste en una carta<br/>
                {{$casilla->mensaje}}<br/>
                @if(isset($casilla->perdio))
                    @if($casilla->perdio==1)
                        Ya perdiste;
                    @endif
                @endif
            </div>
        </div>
        <div class="row">
        </div>
    </div>
</div>
@endsection

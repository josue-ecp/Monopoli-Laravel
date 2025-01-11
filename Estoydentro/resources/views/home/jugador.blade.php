


@extends('app.master')

@section('titulo')
Bienvenido {{ $nombre }}!!
@endsection

@section('contenido')
<div class="ibox ">
    <div class="ibox-title">
        <h5>Home del jugador</h5>
        <div class="ibox-tools">
            <a href="{{ action([App\Http\Controllers\PartidaController:: class, 'formulario']) }}" class="btn btn-success">
                Crear partida
            </a>
            <a href="{{ action([App\Http\Controllers\PartidaController:: class, 'formulario_unir']) }}" class="btn btn-info">
                Unirme a partida
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-wrench"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Dinero</th>
                        <th>Fecha</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <?php
                $jugador_visita = dame_jugador();
                ?>
                @foreach($partidas as $partida)
                <tr>
                    <td>{{ $partida->nombre }}</td>
                    <td>{{ $partida->clave }}</td>
                    <td>{{ $partida->dinero }}</td>
                    <td>{{ $partida->fecha }}</td>
                    <td>
                        @if($partida->status == 0)
                            @if($jugador_visita->id == $partida->idjugador)
                                <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'iniciar']) }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="idpartida" value="{{ $partida->id }}">
                                    <button class="btn btn-info" type="submit">Iniciar partida</button>
                                </form>
                            @endif
                        @else
                            <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'continuar']) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="idpartida" value="{{ $partida->id }}">
                                <button class="btn btn-warning" type="submit">Continuar partida</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection

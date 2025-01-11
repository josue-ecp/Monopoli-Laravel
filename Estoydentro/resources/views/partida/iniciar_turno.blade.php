@extends('app.master')

@section('titulo')
Iniciar turno
@endsection

@section('contenido')
<div class="ibox">
    <div class="ibox-title">
        <h5>Es tu turno</h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <!-- Contenedor con d-flex para alinear los botones horizontalmente -->
            <div class="d-flex gap-3">
                <!-- Botón para iniciar turno -->
                <form action="{{ action([App\Http\Controllers\PartidaController::class, 'jugar_turno']) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                    <button type="submit" class="btn btn-success">Iniciar turno</button>
                </form>

                <!-- Botón para gestionar propiedades -->
                <form action="{{ action([App\Http\Controllers\PartidaController::class, 'gestionarPropiedades']) }}" method="GET">
                    <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                    <input type="hidden" name="idjugador" value="{{ $idjugador }}">
                    <button type="submit" class="btn btn-primary">Comprar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('app.master')

@section('titulo')
LINEA AEREA ocupada
@endsection

@section('contenido')
<div class="ibox ">
    <div class="ibox-title">
        <h5>LINEA AEREA ocupada</h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                Caiste en {{ $casilla->info_propiedad->nombre }}<br/>
                y es de {{ $casilla->idjugador }}<br/>
                @if($casilla->belong == 1)
                    Disfruta tu casilla
                @else
                    Cuesta: ${{ $casilla->info_propiedad->precio }}<br/>
                    @if($casilla->info_pertenece->status == 1)
                        Hay que pagar
                    @else
                        Esta hipotecada huye!!!
                    @endif
                @endif
            </div>
        </div>
        @if($casilla->belong == 0)
            @if($casilla->info_pertenece->status == 1)
                <div class="row">
                    <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'pagar_renta']) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="dinero" value="{{ $casilla->info_propiedad->precio }}">
                        <input type="hidden" name="idpropiedad" value="{{ $casilla->info_propiedad->id }}">
                        <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                        <button type="submit" class="btn btn-warning">Pagar renta</button>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
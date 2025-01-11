@extends('app.master')

@section('titulo')
Iniciar turno
@endsection

@section('contenido')
<div class="ibox ">
    <div class="ibox-title">
    
        <h5>Propiedad disponible</h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                Caiste en {{ $casilla->info_propiedad->nombre}}<br/>
                Cuesta: ${{ $casilla->info_propiedad->precio}}<br/>
                ¿Quieres comprarla?
                
            </div>
           
        </div>
        <div class="row">
            <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'comprar_propiedad']) }}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="idpropiedad" value="{{ $casilla->info_propiedad->id }}">
                <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                <input type="hidden" name="dinero" value="{{ $casilla->info_propiedad->precio }}">
                
                <button type="submit" class="btn btn-success">Sí</button>
                <button type="submit" class="btn btn-danger">NO</button>
            </form>
        </div>
    </div>
</div>
@endsection
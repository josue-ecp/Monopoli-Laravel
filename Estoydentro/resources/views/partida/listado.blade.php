
@extends('app.master')

@section('titulo')
Listado de Partidas
@endsection


@section('contenido')




<div class="ibox-title">
                 
                    <div class="ibox-content">

 
<div class="container">
    <div class="col-md-12">
        <h2>Catálogo de partidas</h2>
        <a class="btn btn-info" href="{{ action([App\Http\Controllers\PartidaController:: class, 'formulario']) }}">Agregar partida</a>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Clave</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
            <tr>
                <td><a href="{{ action([App\Http\Controllers\PartidaController:: class, 'formulario'],['id'=>$registro->id]) }}">{{ $registro->clave }}</a></td>
                <td>{{ $registro->fecha }}</td>
                
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
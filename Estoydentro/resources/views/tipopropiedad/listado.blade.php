

@extends('app.master')

@section('titulo')
Listado de Tipo Propiedad
@endsection


@section('contenido')




<div class="ibox-title">
                        
                    <div class="ibox-content">

             
<div class="container">
    <div class="col-md-12">
        <h2>Catálogo de Tipo de Propiedad</h2>
        <a class="btn btn-info" href="{{ action([App\Http\Controllers\TipopropiedadController:: class, 'formulario']) }}">Agregar Tipo de Propiedad</a>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
            <tr>
                <td><a href="{{ action([App\Http\Controllers\TipopropiedadController:: class, 'formulario'],['id'=>$registro->id]) }}">{{ $registro->nombre }}</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
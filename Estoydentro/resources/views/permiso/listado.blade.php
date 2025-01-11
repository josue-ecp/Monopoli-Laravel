@extends('app.master')

@section('titulo')
Listado de Permisos
@endsection

@section('contenido')




<div class="ibox-title">
                
                    <div class="ibox-content">

                    <div class="container">
    <div class="col-md-12">
        <h2>Catálogo de Permisos</h2>
        <a class="btn btn-info" href="{{ action([App\Http\Controllers\PermisoController:: class, 'formulario']) }}">Agregar Tipo de Propiedad</a>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>clave</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
            <tr>
                <td>{{ $registro->id }}</td>
                <td><a href="{{ action([App\Http\Controllers\PermisoController:: class, 'formulario'],['id'=>$registro->id]) }}">{{ $registro->nombre }}</a></td>
                <td>{{ $registro->clave }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
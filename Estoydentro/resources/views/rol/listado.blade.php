@extends('app.master')


@section('titulo')
Listado de Roles
@endsection

@section('contenido')




<div class="ibox-title">
                      

                    <div class="container">
                      <div style="margin-bottom: 20px;" class="col-md-12">
                        <h2>Listado de Roles</h2>
                        <a class="btn btn-info" href="{{ action([App\Http\Controllers\RolController:: class, 'formulario']) }}">Agregar personajes</a>
                        </div>
 

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>permisos</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registros as $registro)
                            <tr>
                                <td><a href="{{ action([App\Http\Controllers\RolController:: class, 'formulario'],['id'=>$registro->id]) }}">{{ $registro->nombre }}</a></td>
                                <td>
                          <a href="{{ action([App\Http\Controllers\RolxPermisoController:: class, 'formulario'],['id'=>$registro->id]) }}">Permisos</a>
                        </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
@endsection

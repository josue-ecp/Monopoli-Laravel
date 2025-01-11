@extends('app.master')

@section('titulo')
Listado de Jugadores
@endsection



@section('contenido')




<div class="ibox-title">
                   
                    <div class="ibox-content">

                    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\JugadorController:: class, 'formulario']) }}" method="GET">
                    {{csrf_field()}}
                    <button class="btn btn-info" type="submit">Agregar</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Foto</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jugadores as $jugador)
                        <tr>
                            <td>{{$jugador->id}}</td>
                            <td>
                                <a href="{{ action([App\Http\Controllers\JugadorController:: class, 'formulario'],['id'=>$jugador->id]) }}">
                                    {{$jugador->nombre}}
                                </a>
                            </td>
                            <td>{{$jugador->edad}}</td>
                            <td>
                                <img width="50" height="50" src="{{ action([App\Http\Controllers\JugadorController:: class, 'mostrar_foto'],[$jugador->foto]) }}">
                            </td>
                            <td>
                                <form action="{{ action([App\Http\Controllers\JugadorController:: class, 'operaciones']) }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$jugador->id}}"/>
                                    <input type="hidden" name="operacion" value="Eliminar"/>
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('app.master')

@section('titulo')
Listado de Propiedad X Jugador
@endsection


@section('contenido')




<div class="ibox-title">
            
                    <div class="ibox-content">

                    <div class="container">
        <div class="row">
            <div style="margin-bottom: 20px;" class="col-md-12">
                <form action="{{ action([App\Http\Controllers\PropiedadxjugadorController:: class, 'formulario']) }}" method="GET">
                    {{csrf_field()}}
                    <button style="margin-bottom: 20px;" class="btn btn-info" type="submit">Agregar</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Propiedad</th>
                            <th>Jugador</th>
                            <th>Partida</th>
                            
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($propiedadesxjugadores as $propiedadxjugador)
                        <tr>
                            <td>{{$propiedadxjugador->id}}</td>
                            <td>
                                <a href="{{ action([App\Http\Controllers\PropiedadxjugadorController:: class, 'formulario'],['id'=>$propiedadxjugador->id]) }}">
                                {{$propiedadxjugador->idpropiedad}}
                                </a>
                            </td>
                            <td>
                                {{$propiedadxjugador->idjugador}}
                            </td>
                            <td>
                                {{$propiedadxjugador->idpartida}}
                            </td>
                            <td>
                                <form action="{{ action([App\Http\Controllers\PropiedadxjugadorController:: class, 'operaciones']) }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$propiedadxjugador->id}}"/>
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


@endsection
   

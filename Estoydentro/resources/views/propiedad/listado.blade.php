@extends('app.master')

@section('titulo')
Listado de Propiedades
@endsection


@section('contenido')




<div class="ibox-title">
                        
                    <div class="ibox-content">

                    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\PropiedadController:: class, 'formulario']) }}" method="GET">
                    {{csrf_field()}}
                    <button class="btn btn-info" type="submit">Agregar</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Tipo de propiedad</th>
                            <th>Region</th>
                            <th>Orden</th>
                            <th>Foto</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($propiedades as $propiedad)
                        <tr>
                            <td>{{$propiedad->id}}</td>
                            <td>
                                <a href="{{ action([App\Http\Controllers\PropiedadController:: class, 'formulario'],['id'=>$propiedad->id]) }}">
                                    {{$propiedad->nombre}}
                                </a>
                            </td>
                            <td>
                                {{$propiedad->precio}}
                            </td>
                            <td>
                                {{$propiedad->idtipopropiedad}}
                            </td>
                            <td>
                                {{$propiedad->idregion}}
                            </td>
                            <td>
                                {{$propiedad->orden}}
                            </td>
                            <td>
                                <img width="50" height="50" src="{{ action([App\Http\Controllers\PropiedadController:: class, 'mostrar_foto'],[$propiedad->foto]) }}">
                            </td>
                            <td>
                                <form action="{{ action([App\Http\Controllers\PropiedadController:: class, 'operaciones']) }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$propiedad->id}}"/>
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
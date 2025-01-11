@extends('app.master')
@section('titulo')
Listado de Regiones
@endsection


@section('contenido')




<div class="ibox-title">
                     

                    
    <div class="container">
        <div class="row">
            <div style="margin-bottom: 20px;" class="col-md-12">
                <form action="{{ action([App\Http\Controllers\RegionController:: class, 'formulario']) }}" method="GET">
                    {{csrf_field()}}
                    <button class="btn btn-info" type="submit">Agregar</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Foto</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regiones as $region)
                        <tr>
                            <td>{{$region->id}}</td>
                            <td>
                                <a href="{{ action([App\Http\Controllers\RegionController:: class, 'formulario'],['id'=>$region->id]) }}">
                                    {{$region->nombre}}
                                </a>
                            </td>
                            <td>
                                {{$region->color}}
                            </td>
                            <td>
                                <img width="50" height="50" src="{{ action([App\Http\Controllers\RegionController:: class, 'mostrar_foto'],[$region->foto]) }}">
                            </td>
                            <td>
                                <form action="{{ action([App\Http\Controllers\RegionController:: class, 'operaciones']) }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$region->id}}"/>
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

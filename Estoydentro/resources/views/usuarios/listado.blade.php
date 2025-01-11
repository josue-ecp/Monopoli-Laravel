
    

  
    @extends('app.master')

    @section('titulo')
Listado de Usuarios
@endsection


@section('contenido')




<div class="ibox-title">
           
                    <div class="ibox-content">
                    <div class="container">
        <div style="margin-bottom: 20px;" class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\UsuariosController:: class, 'formulario']) }}" method="GET">
                    {{csrf_field()}}
                    <button class="btn btn-info" type="submit">Agregar</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Rol</th>
                            
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->id}}</td>
                            <td>
                                <a href="{{ action([App\Http\Controllers\UsuariosController:: class, 'formulario'],['id'=>$usuario->id]) }}">
                                {{$usuario->email}}
                                </a>
                            </td>
                            <td>
                                {{$usuario->nombre}}
                            </td>
                            <td>
                                <form action="{{ action([App\Http\Controllers\UsuariosController:: class, 'operaciones']) }}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$usuario->id}}"/>
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
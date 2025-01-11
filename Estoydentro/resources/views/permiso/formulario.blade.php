
@extends('app.master')

@section('titulo')
Formulario de Permisos
@endsection


@section('contenido')


<div class="ibox-title">
                        <h5>Basic form <small>Simple login form example</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                  
<div class="container">
    <div class="col-md-12">
        <h2>Formulario de Permisos</h2>
        <form action="{{ action([App\Http\Controllers\PermisoController:: class, 'save']) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $permiso->id }}">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ $permiso->nombre }}">
                <label for="clave">Clave</label>
                <input type="text" class="form-control" name="clave" value="{{ $permiso->clave }}">
            </div>

            <input name="operacion" class="btn btn-success" value="{{ $operacion }}" type="submit">
            @if($operacion == 'Modificar')
                <input name="operacion" class="btn btn-danger" value="Eliminar" type="submit">
            @endif
        </form>
    </div>
</div>
                 
                    </div>
@endsection

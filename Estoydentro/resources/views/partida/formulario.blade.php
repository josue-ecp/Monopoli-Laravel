
@extends('app.master')

@section('titulo')
Crear partida
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
        <h2>Crear Partida</h2>
        <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'save']) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="clave">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="" placeholder="Llena el campo vacios" required>
            </div>
            <div class="form-group">
            <label for="clave">Clave</label>
            <input type="text" class="form-control" name="clave" value="" placeholder="Llena el campo vacios" required>
            </div>
            
           <input type="submit" class="btn btn-success" name="operacion" value="Crear">
        </form>
    </div>
</div>
                    </form>
                 
                    </div>
@endsection
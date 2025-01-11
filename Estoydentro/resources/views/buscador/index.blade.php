

    @extends('app.master')
    @section('titulo')
Buscador
@endsection



@section('contenido')




<div class="ibox-title">
                        <h5>Basic Table</h5>
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
        <div style="margin-top:10px;margin-bottom:10px" class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\BuscadorController:: class, 'index']) }}" method="POST">
                    {{csrf_field()}}
                    <input class="form-control" type="text" name="criterio" value="{{$criterio}}" />
                    <button style="margin-top:10px;margin-bottom:10px" class="btn btn-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                           
                            <th>Tipo de Propiedad</th>
                            <th>Región</th>
                            <th>Precio</th>
                            <th>Clave de Partida</th>
                            <th>Jugador</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros as $registro)
                        <tr>
                            
                            <td>{{$registro->tipo_propiedad}}</td>
                            <td>{{$registro->region}}</td>
                            <td>{{$registro->precio}}</td>
                            <td>{{$registro->clave}}</td>
                            <td>{{$registro->jugador}}</td>
                            

                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
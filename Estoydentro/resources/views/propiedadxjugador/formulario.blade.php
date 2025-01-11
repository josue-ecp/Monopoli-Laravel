
    @extends('app.master')

@section('titulo')
Formulario de propiedadxjugadores
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
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\PropiedadxjugadorController:: class, 'operaciones']) }}" 
                      enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$propiedadxjugador->id}}"/>
                    <input type="hidden" name="operacion" value="{{$operacion}}"/>

                    <!--<label for="">Tipo de Propiedad</label>
                    <input class="form-control" type="text" name="idpropiedad" value="{{$propiedadxjugador->idpropiedad}}" />
                    <label for="">Region</label>
                    <input class="form-control" type="text" name="idregion" value="{{$propiedadxjugador->idregion}}" />-->
                    <label for="idpropiedad">Propiedad</label>
                    <select class="form-control" name="idpropiedad">
                        @foreach($propiedades as $propiedad)
                            <option value="{{ $propiedad->id }}" {{ $propiedadxjugador->idpropiedad == $propiedad->id ? 'selected' : '' }}>
                                {{ $propiedad->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <label for="idjugador">Jugador</label>
                    <select class="form-control" name="idjugador">
                        @foreach($jugadores as $jugador)
                            <option value="{{ $jugador->id }}" {{ $propiedadxjugador->idjugador == $jugador->id ? 'selected' : '' }}>
                                {{ $jugador->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <label for="idpartida">Partida</label>
                    <select class="form-control" name="idpartida">
                        @foreach($partidas as $partida)
                            <option value="{{ $partida->id }}" {{ $propiedadxjugador->idpartida == $partida->id ? 'selected' : '' }}>
                                {{ $partida->clave }}
                            </option>
                        @endforeach
                    </select>
                    
                    
                    <button class="btn btn-success" type="submit">{{$operacion}}</button>
                </form>
            </div>
        </div>
    </div>
                 
                    </div>
@endsection

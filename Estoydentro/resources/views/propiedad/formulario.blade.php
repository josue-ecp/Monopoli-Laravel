@extends('app.master')

@section('titulo')
Formulario de Propiedades
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
                <form action="{{ action([App\Http\Controllers\PropiedadController:: class, 'operaciones']) }}" 
                      enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$propiedad->id}}"/>
                    <input type="hidden" name="operacion" value="{{$operacion}}"/>
                    <label for="">Nombre</label>
                    <input class="form-control" type="text" name="nombre" value="{{$propiedad->nombre}}" />
                    <label for="">Precio</label>
                    <input class="form-control" type="number" name="precio" value="{{$propiedad->precio}}" />
                    <!--<label for="">Tipo de Propiedad</label>
                    <input class="form-control" type="text" name="idtipopropiedad" value="{{$propiedad->idtipopropiedad}}" />
                    <label for="">Region</label>
                    <input class="form-control" type="text" name="idregion" value="{{$propiedad->idregion}}" />-->
                    <label for="idtipopropiedad">Tipo de Propiedad</label>
                    <select class="form-control" name="idtipopropiedad">
                        @foreach($tipos_propiedad as $tipo)
                            <option value="{{ $tipo->id }}" {{ $propiedad->idtipopropiedad == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <label for="idregion">Región</label>
                    <select class="form-control" name="idregion">
                        @foreach($regiones as $region)
                            <option value="{{ $region->id }}" {{ $propiedad->idregion == $region->id ? 'selected' : '' }}>
                                {{ $region->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <label for="">Orden</label>
                    <input class="form-control" type="text" name="orden" value="{{$propiedad->orden}}" />
                    <label for="">Foto</label>
                    <input class="form-control" type="file" name="foto" value="" />
                    <button class="btn btn-success" type="submit">{{$operacion}}</button>
                </form>
            </div>
        </div>
    </div>
                 
                    </div>
@endsection


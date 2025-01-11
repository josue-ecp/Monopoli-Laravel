
    @extends('app.master')

@section('titulo')
Formulario de Regiones
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
                 
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\RegionController:: class, 'operaciones']) }}" 
                      enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$region->id}}"/>
                    <input type="hidden" name="operacion" value="{{$operacion}}"/>
                    <label for="">Nombre</label>
                    <input class="form-control" type="text" name="nombre" value="{{$region->nombre}}" />
                    <label for="">Color</label>
                    <input class="form-control" type="text" name="color" value="{{$region->color}}" />
                    <label for="">Foto</label>
                    <input class="form-control" type="file" name="foto" value="" />
                    <button class="btn btn-success" type="submit">{{$operacion}}</button>
                </form>
            </div>
        </div>
    </div>
                 
                    </div>
@endsection


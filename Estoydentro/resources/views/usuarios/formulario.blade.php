
    

    @extends('app.master')

@section('titulo')
Formulario de Usuarios
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
                <form action="{{ action([App\Http\Controllers\UsuariosController:: class, 'operaciones']) }}" 
                      enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$usuario->id}}"/>
                    <input type="hidden" name="operacion" value="{{$operacion}}"/>
                    <label for="">email</label>
                    <input class="form-control" type="text" name="email" value="{{$usuario->email}}" />
                    <label for="">password</label>
                    <input class="form-control" type="password" name="password" value="" />
                    <label for="idrol">Propiedad</label>
                    <select class="form-control" name="idrol">
                        @foreach($roles as $rol)
                        <?php 
                        
                        $select='';
                        if($rol->id==$usuario->idrol)
                        $select='selected';
                        ?>
                            <option {{$select}} value="{{ $rol->id }}" {{ $usuario->idrol}}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <!--<label for="">Tipo de Propiedad</label>
                    <input class="form-control" type="text" name="idrol" value="{{$usuario->idpropiedad}}" />
                    <label for="">Region</label>
                    <input class="form-control" type="text" name="idregion" value="{{$usuario->idregion}}" />-->
                    
                    
                    <button class="btn btn-success" type="submit">{{$operacion}}</button>
                </form>
            </div>
        </div>
    </div>
                 
                    </div>
@endsection



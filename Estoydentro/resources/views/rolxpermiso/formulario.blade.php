@extends('app.master')

@section('titulo')
Formulario de Rol x Permiso
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
    <div class="card-body">
      <div id="app" class="row">
        <form action="{{ action([App\Http\Controllers\RolxPermisoController:: class, 'save']) }}" method="POST">
          {{csrf_field()}}
          <input type="hidden" name="idrol" value="{{$id}}" />
          <table class="table table-bordered">
            @foreach($permisos as $permiso)
            <tr>
              <td>
                <?php
                  $ch='';
                  if($permiso->asignado==true)
                    $ch=' checked ';
                ?>
                <input {{$ch}} type="checkbox" name="idpermiso[]" value="{{$permiso->id}}">
              </td>
              <td>{{$permiso->nombre}}</td>
              <td>{{$permiso->clave}}</td>
            </tr>
            @endforeach
          </table>
          <button type="submit" class="btn btn-success">Asignar permisos</button>
        </form>
      </div>
    </div>
  </div>
                 
                    </div>
@endsection

  

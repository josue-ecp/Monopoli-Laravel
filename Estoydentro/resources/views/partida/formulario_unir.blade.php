@extends('app.master')

@section('titulo')
    Unir partida
@endsection

@section('contenido')
<div class="ibox">
    <div class="ibox-title">
        <h5>Unir partida</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-wrench"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="#" class="dropdown-item">Config option 1</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item">Config option 2</a>
                </li>
            </ul>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <form action="{{ action([App\Http\Controllers\PartidaController:: class, 'unir']) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="form-label" for="clave">Clave</label>
                    <input type="text" name="clave" class="form-control" value="" placeholder="Ingrese la clave">
                </div>
                <input type="submit" class="btn btn-success" name="operacion" value="Unir">
            </form>
        </div>
    </div>
</div>
@endsection
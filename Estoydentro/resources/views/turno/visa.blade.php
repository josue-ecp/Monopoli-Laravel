@extends ('app.master')
@section('titulo')
Visa
@endsection
@section('contenido') 
<div class="ibox">
    <div class="ibox-title">
        <h5>Salida</h5>
        <div class="ibox-tools"> </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                Caiste en Visa<br/>
                
                Te descontaron 10,000
                @if($casilla->perdio==1)
                    Ya perdiste
                @endif
            </div>
        </div>
        <div class="row">
        </div>
    </div>
</div>
@endsection

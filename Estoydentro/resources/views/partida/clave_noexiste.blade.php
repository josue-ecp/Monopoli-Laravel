@extends('app.master')

@section('titulo')
ERROR
@endsection

@section('contenido')
<div class="ibox ">
    <div class="ibox-title">
        <h5>ERROR</h5>
        <div class="ibox-tools">
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
               {{ $mensaje }}
            </div>
        </div>
        <div class="row">
        </div>
    </div>
</div>
@endsection

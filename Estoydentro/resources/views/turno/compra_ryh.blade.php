@extends('app.master')

@section('titulo')
Gestionar Propiedades, Restaurantes y Hoteles
@endsection

@section('contenido')
<div class="ibox">
    <div class="ibox-title">
        <h5>Gestión de Propiedades, Restaurantes y Hoteles</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <!-- Mensajes de éxito o error -->
            @if(session('success'))
                <div class="alert alert-success col-12 mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger col-12 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Card para comprar hotel -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Comprar Hotel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ action([App\Http\Controllers\PartidaController::class, 'verificarRegionYComprarHotel']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                            <input type="hidden" name="idjugador" value="{{ $idjugador }}">

                            <div class="form-group">
                                <label for="propiedadHotel">Selecciona tu propiedad para el hotel:</label>
                                <select name="id_propiedad" id="propiedadHotel" class="form-control">
                                    @foreach($propiedades as $propiedad)
                                        @if(!$propiedad->hotel) <!-- Mostrar solo propiedades sin hotel -->
                                            <option value="{{ $propiedad->id_propiedad }}">
                                                {{ $propiedad->nombre_propiedad }} (Región: {{ $propiedad->nombre_region }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Comprar Hotel</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card para comprar restaurantes -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Comprar Restaurante(s)</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ action([App\Http\Controllers\PartidaController::class, 'comprarRestauranteHotel']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="idpartida" value="{{ $idpartida }}">
                            <input type="hidden" name="idjugador" value="{{ $idjugador }}">
                            <input type="hidden" name="tipo_compra" value="restaurante">

                            <div class="form-group">
                                <label for="propiedadRestaurante">Selecciona tu propiedad para el restaurante:</label>
                                <select name="id_propiedad" id="propiedadRestaurante" class="form-control">
                                    @foreach($propiedades as $propiedad)
                                        @if($propiedad->restaurantes < 3) <!-- Mostrar solo propiedades con menos de 3 restaurantes -->
                                            <option value="{{ $propiedad->id_propiedad }}">
                                                {{ $propiedad->nombre_propiedad }} ({{ $propiedad->restaurantes }} Restaurante(s))
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad de restaurantes:</label>
                                
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Comprar Restaurante(s)</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

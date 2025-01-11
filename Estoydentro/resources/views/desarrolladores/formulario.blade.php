<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Página de prueba del Bootstrap</title>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('public/bootstrap.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="col-md-12">
        <h2>Formulario de desarrolladores</h2>
        <form action="{{ action([App\Http\Controllers\DesarrolladoresController:: class, 'save']) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $desarrollador->id }}">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ $desarrollador->nombre }}">
            </div>
            <div class="form-group">
                <label for="asignacion">Asignacion</label>
                <input type="text" class="form-control" name="asignacion" value="{{ $desarrollador->asignacion }}">
            </div>
            <input name="operacion" class="btn btn-success" value="{{ $operacion }}" type="submit">
            @if($operacion == 'Modificar')
                <input name="operacion" class="btn btn-danger" value="Eliminar" type="submit">
            @endif
        </form>
    </div>
</div>
<script src="{{ asset('public/jquery.min.js') }}"></script>
<script src="{{ asset('public/bootstrap.min.js') }}"></script>
</body>
</html>
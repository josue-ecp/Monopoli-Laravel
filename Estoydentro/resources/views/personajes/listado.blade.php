<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Página de prueba del Bootstrap</title>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.6/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--<link rel="stylesheet" href="{{ asset('public/bootstrap.css') }}">-->
</head>
<body>
<div class="container">
    <div class="col-md-12">
        <h2>Catálogo de personajes</h2>
        <a class="btn btn-info" href="{{ action([App\Http\Controllers\PersonajesController:: class, 'formulario']) }}">Agregar personajes</a>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
            <tr>
                <td><a href="{{ action([App\Http\Controllers\PersonajesController:: class, 'formulario'],['id'=>$registro->id]) }}">{{ $registro->nombre }}</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('public/jquery.min.js') }}"></script>
<script src="{{ asset('public/bootstrap.min.js') }}"></script>
</body>
</html>

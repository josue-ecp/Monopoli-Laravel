<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Error 500</title>

    <link href="{{ asset('app/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('app/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('app/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('app/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: #fff;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .error-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 120px;
            font-weight: bold;
            margin: 0;
            color: #fff;
        }
        h3 {
            font-size: 24px;
            margin: 20px 0;
            color: #fff;
        }
        .error-desc {
            font-size: 16px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }
        .btn-primary {
            background: #4CAF50;
            border: none;
            border-radius: 5px;
            height: 45px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
        }
        .btn-primary:hover {
            background: #388E3C;
        }
    </style>
</head>

<body>
    <div class="error-box animated fadeInDown">
        <h1>500</h1>
        <h3 class="font-bold">Datos no encontrados</h3>
        <div class="error-desc">
            Datos incorrectos o correo no registrado. Por favor, verifica e intenta nuevamente.
        </div>
        <a href="{{ action([App\Http\Controllers\LoginController::class, 'index']) }}" class="btn btn-primary m-t">Volver al Login</a>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('app/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('app/js/popper.min.js') }}"></script>
    <script src="{{ asset('app/js/bootstrap.js') }}"></script>
</body>

</html>

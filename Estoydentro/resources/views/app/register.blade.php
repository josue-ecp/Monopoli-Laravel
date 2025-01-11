<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    
    <!-- Bootstrap -->
    <link href="{{ asset('app/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('app/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('app/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('app/css/style.css') }}" rel="stylesheet">
    
    <!-- Estilo personalizado -->
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
        .register-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        .register-box h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 5px;
            height: 45px;
        }
        .btn-primary {
            background: #4CAF50;
            border: none;
            border-radius: 5px;
            height: 45px;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background: #388E3C;
        }
    </style>
</head>

<body>
    <div class="register-box text-center">
        <h1>Crea tu cuenta</h1>
        <p>Completa el formulario para registrarte</p>
        <form class="m-t" role="form" action="{{ action([App\Http\Controllers\JugadorController::class, 'autoregistro']) }}" 
              enctype="multipart/form-data"
              method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="edad" placeholder="Edad" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Regístrate</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('app/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('app/js/popper.min.js') }}"></script>
    <script src="{{ asset('app/js/bootstrap.js') }}"></script>
</body>

</html>

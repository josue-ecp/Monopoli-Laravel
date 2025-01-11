<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    
    <!-- Bootstrap -->
    <link href="{{ asset('app/css/bootstrap.min.css') }}" rel="stylesheet">
    
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
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
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
        .btn-link {
            color: #fff;
            font-size: 14px;
            text-decoration: underline;
        }
        .btn-link:hover {
            color: #B9F6CA;
        }
    </style>
</head>

<body>
    <div class="login-container text-center">
        <h1>Bienvenido</h1>
        <p>Por favor, inicia sesión para continuar</p>
        <form action="{{ action([App\Http\Controllers\LoginController::class, 'login']) }}" method="POST">
            {{ csrf_field() }}
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        <p class="mt-3">
            <a href="{{ action([App\Http\Controllers\JugadorController::class, 'registrate']) }}" class="btn-link">¿No tienes una cuenta? Regístrate</a>
        </p>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('app/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('app/js/popper.min.js') }}"></script>
    <script src="{{ asset('app/js/bootstrap.js') }}"></script>
</body>

</html>

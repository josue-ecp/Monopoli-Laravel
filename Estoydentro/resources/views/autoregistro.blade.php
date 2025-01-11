<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Formulario de PropiedadxJugador</title>
    <!--<link rel="stylesheet" href="{{asset('public/bootstrap.css')}}">-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ action([App\Http\Controllers\JugadorController:: class, 'autoregistro']) }}" 
                      enctype="multipart/form-data"
                      method="POST">
                    {{csrf_field()}}
                    <label for="">Nombre Completo</label>
                    <input class="form-control" type="text" name="nombre" value="" />
                    <label for="">edad</label>
                    <input class="form-control" type="text" name="edad" value="" />
                    <label for="">email</label>
                    <input class="form-control" type="text" name="email" value="" />
                    <label for="">password</label>
                    <input class="form-control" type="password" name="password" value="" />
                    
                    

                    
                    <button class="btn btn-success" type="submit">Registrate</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('public/jquery.min.js')}}"></script>
    <script src="{{asset('public/bootstrap.min.js')}}"></script>
</body>
</html>
